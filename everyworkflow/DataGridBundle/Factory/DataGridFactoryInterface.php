<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\ActionInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridParameterInterface;
use EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface;

interface DataGridFactoryInterface
{
    public function createConfig(array $data = []): DataGridConfigInterface;

    public function createAction(string $className, array $data = []): ActionInterface;

    public function createParameter(
        array $data = [],
        array $filters = [],
        array $options = []
    ): DataGridParameterInterface;

    public function createCollection(array $data = []): DataCollectionInterface;

    public function createSource(
        BaseRepositoryInterface | array $repositoryOrDataObjects,
        DataGridConfigInterface | null | array $dataGridConfig = null,
        DataGridParameterInterface | null | array $dataGridParameter = null,
        FormInterface | null | array $form = null,
        DataCollectionInterface | null | array $dataCollection = null,
    ): ArraySourceInterface;

    public function create(
        BaseRepositoryInterface | array $repositoryOrDataObjects,
        DataGridConfigInterface | null | array $dataGridConfig = null,
        DataGridParameterInterface | null | array $dataGridParameter = null,
        FormInterface | null | array $form = null,
        array $data = []
    ): DataGridInterface;
}
