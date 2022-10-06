<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\ActionInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySource;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataCollection;
use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridParameter;
use EveryWorkflow\DataGridBundle\Model\DataGridParameterInterface;
use EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface;

class DataGridFactory implements DataGridFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected FormFactoryInterface $formFactory;
    /**
     * @var DataObjectFactoryInterface
     */
    protected DataObjectFactoryInterface $dataObjectFactory;
    /**
     * @var ActionFactoryInterface
     */
    protected ActionFactoryInterface $actionFactory;

    public function __construct(
        FormFactoryInterface $formFactory,
        DataObjectFactoryInterface $dataObjectFactory,
        ActionFactoryInterface $actionFactory
    ) {
        $this->formFactory = $formFactory;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->actionFactory = $actionFactory;
    }

    public function createConfig(array $data = []): DataGridConfigInterface
    {
        return new DataGridConfig($this->dataObjectFactory->create($data), $this->actionFactory);
    }

    public function createAction(string $className, array $data = []): ActionInterface
    {
        return $this->actionFactory->create($className, $data);
    }

    public function createParameter(
        array $data = [],
        array $filters = [],
        array $options = []
    ): DataGridParameterInterface {
        return new DataGridParameter($this->dataObjectFactory->create($data), $filters, $options);
    }

    public function createCollection(array $data = []): DataCollectionInterface
    {
        return new DataCollection($this->dataObjectFactory->create($data));
    }

    protected function getConfigObject(
        DataGridConfigInterface | null | array $dataGridConfig = null
    ): DataGridConfigInterface {
        if (is_array($dataGridConfig)) {
            $dataGridConfig = $this->createConfig($dataGridConfig);
        } elseif (is_null($dataGridConfig)) {
            $dataGridConfig = $this->createConfig();
        }
        return $dataGridConfig;
    }

    protected function getParameterObject(
        DataGridParameterInterface | null | array $dataGridParameter = null
    ): DataGridParameterInterface {
        if (is_array($dataGridParameter)) {
            $dataGridParameter = $this->createParameter($dataGridParameter);
        } elseif (is_null($dataGridParameter)) {
            $dataGridParameter = $this->createParameter();
        }
        return $dataGridParameter;
    }

    protected function getFormObject(FormInterface | null | array $form = null): FormInterface
    {
        if (is_array($form)) {
            if (isset($form['fields'], $form['data'])) {
                $form = $this->formFactory->create($form['data'])->setFields($form['fields']);
            } else {
                $form = $this->formFactory->create()->setFields($form);
            }
        } elseif (is_null($form)) {
            $form = $this->formFactory->create();
        }
        return $form;
    }

    public function createSource(
        BaseRepositoryInterface | array $repositoryOrDataObjects,
        DataGridConfigInterface | null | array $dataGridConfig = null,
        DataGridParameterInterface | null | array $dataGridParameter = null,
        FormInterface | null | array $form = null,
        DataCollectionInterface | null | array $dataCollection = null,
    ): ArraySourceInterface {
        $dataGridConfig = $this->getConfigObject($dataGridConfig);
        $dataGridParameter = $this->getParameterObject($dataGridParameter);
        $form = $this->getFormObject($form);

        if (is_array($dataCollection)) {
            $dataCollection = $this->createCollection($dataCollection);
        } elseif (is_null($dataCollection)) {
            $dataCollection = $this->createCollection();
        }

        if ($repositoryOrDataObjects instanceof BaseRepositoryInterface) {
            return new RepositorySource(
                $repositoryOrDataObjects,
                $dataGridConfig,
                $dataGridParameter,
                $form,
                $dataCollection,
                $this->dataObjectFactory
            );
        }
        return new ArraySource($dataCollection, $this->dataObjectFactory, $repositoryOrDataObjects);
    }

    public function create(
        BaseRepositoryInterface | array $repositoryOrDataObjects,
        DataGridConfigInterface | null | array $dataGridConfig = null,
        DataGridParameterInterface | null | array $dataGridParameter = null,
        FormInterface | null | array $form = null,
        array $data = []
    ): DataGridInterface {
        $dataGridConfig = $this->getConfigObject($dataGridConfig);
        $dataGridParameter = $this->getParameterObject($dataGridParameter);
        $form = $this->getFormObject($form);
        $source = $this->createSource($repositoryOrDataObjects, $dataGridConfig, $dataGridParameter, $form);
        return new DataGrid($this->dataObjectFactory->create($data), $dataGridConfig, $form, $source);
    }
}
