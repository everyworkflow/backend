<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model\Collection;

use Carbon\Carbon;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridParameterInterface;
use EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface;
use MongoDB\BSON\Regex;

class RepositorySource extends ArraySource implements RepositorySourceInterface
{
    public function __construct(
        protected BaseRepositoryInterface $baseRepository,
        protected DataGridConfigInterface $dataGridConfig,
        protected DataGridParameterInterface $dataGridParameter,
        protected FormInterface $form,
        DataCollectionInterface $dataCollection,
        DataObjectFactoryInterface $dataObjectFactory,
    ) {
        parent::__construct($dataCollection, $dataObjectFactory, []);
    }

    public function getRepository(): BaseRepositoryInterface
    {
        return $this->baseRepository;
    }

    public function setRepository(BaseRepositoryInterface $baseRepository): self
    {
        $this->baseRepository = $baseRepository;

        return $this;
    }

    public function getConfig(): DataGridConfigInterface
    {
        return $this->dataGridConfig;
    }

    public function setConfig(DataGridConfigInterface $dataGridConfig): self
    {
        $this->dataGridConfig = $dataGridConfig;

        return $this;
    }

    public function getParameter(): DataGridParameterInterface
    {
        return $this->dataGridParameter;
    }

    public function setParameter(DataGridParameterInterface $dataGridParameter): self
    {
        $this->dataGridParameter = $dataGridParameter;

        return $this;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function setForm(FormInterface $form): self
    {
        $this->form = $form;

        return $this;
    }

    protected function getApplicableFilters(): array
    {
        $applicableFilters = [];

        $filterableColumns = $this->getConfig()->getFilterableColumns();
        $filters = $this->getParameter()->getFilters();
        foreach ($filters as $key => $val) {
            if (in_array($key, $filterableColumns, true)) {
                $applicableFilters[$key] = $val;
            }
        }
        if (isset($applicableFilters['_id'])) {
            /* @psalm-suppress UndefinedClass */
            $applicableFilters['_id'] = new \MongoDB\BSON\ObjectId($applicableFilters['_id']);
        }

        $formData = $this->getForm()->toArray();
        $fields = array_column($formData['fields'], null, 'name');
        foreach ($applicableFilters as $key => $val) {
            /* TODO: find better way to build mongo filter query */
            if (
                isset($fields[$key]['field_type']) &&
                in_array($fields[$key]['field_type'], [
                    'select_field',
                ])
            ) {
                $applicableFilters[$key] = $val;
            } else if (is_string($val)) {
                $applicableFilters[$key] = new Regex($val, 'i');
            } else if (
                is_array($val) && 2 === count($val) &&
                isset($fields[$key]['field_type']) &&
                in_array($fields[$key]['field_type'], [
                    'date_picker_field',
                    'time_picker_field',
                    'date_time_picker_field',
                    'date_range_picker_field',
                    'date_time_range_picker_field',
                ])
            ) {
                $applicableFilters[$key] = [
                    '$gt' => Carbon::parse($val[0])->toDateTimeString(),
                    '$lte' => Carbon::parse($val[1])->toDateTimeString(),
                ];
            }
        }

        return $applicableFilters;
    }

    protected function getApplicableOptions(): array
    {
        $applicableOptions = [];
        $options = $this->getParameter()->getOptions();

        $sortableColumns = $this->getConfig()->getSortableColumns();
        if (isset($options['sort_field'])) {
            if (in_array($options['sort_field'], $sortableColumns, true)) {
                $sortOrder = 1; // asc
                if (isset($options['sort_order']) && 'desc' === $options['sort_order']) {
                    $sortOrder = -1; // desc
                }
                $applicableOptions['sort'][$options['sort_field']] = $sortOrder;
            }
        } else if ($this->getConfig()->getDefaultSortField() && $this->getConfig()->getDefaultSortOrder()) {
            $defaultSortOrder = $this->getConfig()->getDefaultSortOrder();
            $sortOrder = 1; // asc
            if ('desc' === $defaultSortOrder) {
                $sortOrder = -1; // desc
            }
            $applicableOptions['sort'][$this->getConfig()->getDefaultSortField()] = $sortOrder;
        }

        if (isset($options['skip']) && is_numeric($options['skip']) && $options['skip'] > 0) {
            $applicableOptions['skip'] = $options['skip'];
        } else {
            $applicableOptions['skip'] = 0;
        }

        if (isset($options['limit']) && is_numeric($options['limit']) && $options['limit'] > 1) {
            $applicableOptions['limit'] = $options['limit'];
        } else {
            $applicableOptions['limit'] = 20;
        }

        return $applicableOptions;
    }

    protected function processResult(): array
    {
        $mongoCursor = $this->getRepository()->getCollection()
            ->find($this->getApplicableFilters(), $this->getApplicableOptions());
        $results = [];
        foreach ($mongoCursor as $item) {
            if ($item instanceof \MongoDB\Model\BSONDocument) {
                $itemArr = $item->getArrayCopy();
                if (isset($itemArr['_id']) && $itemArr['_id'] instanceof \MongoDB\BSON\ObjectId) {
                    $itemArr['_id'] = (string) $itemArr['_id'];
                }
                $results[] = $this->dataObjectFactory->create($itemArr);
            }
        }

        return $results;
    }

    public function toCollection(): DataCollectionInterface
    {
        $collection = parent::toCollection();
        $applicableFilters = $this->getApplicableFilters();
        $applicableOptions = $this->getApplicableOptions();
        $collection->setPerPage($applicableOptions['limit']);
        $totalCount = $this->getRepository()->getCollection()->countDocuments($applicableFilters);
        $lastPage = 1;
        if ($totalCount > 1 && $collection->getPerPage()) {
            $lastPage = (int) ceil($totalCount / $collection->getPerPage());
        }
        $from = $applicableOptions['skip'];
        $to = $applicableOptions['skip'] + $collection->getPerPage();
        $currentPage = (int) ceil($to / $collection->getPerPage());
        $collection
            ->setTotalCount($totalCount)
            ->setLastPage($lastPage)
            ->setFrom($from)
            ->setTo($to)
            ->setCurrentPage($currentPage);

        return $collection;
    }
}
