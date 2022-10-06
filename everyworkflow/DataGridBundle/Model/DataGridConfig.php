<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataGridBundle\Factory\ActionFactoryInterface;
use EveryWorkflow\DataGridBundle\Model\ActionInterface;

class DataGridConfig implements DataGridConfigInterface
{
    /**
     * @var DataObjectInterface
     */
    protected DataObjectInterface $dataObject;
    /**
     * @var ActionFactoryInterface
     */
    protected ActionFactoryInterface $actionFactory;

    public function __construct(DataObjectInterface $dataObject, ActionFactoryInterface $actionFactory)
    {
        $this->dataObject = $dataObject;
        $this->actionFactory = $actionFactory;
    }

    public function getActionFactory(): ActionFactoryInterface
    {
        return $this->actionFactory;
    }

    /**
     * @return ActionInterface[]
     */
    public function getHeaderActions(): array
    {
        return $this->dataObject->getData(self::KEY_HEADER_ACTIONS) ?? [];
    }

    /**
     * @param ActionInterface[] $actions
     * @return $this
     */
    public function setHeaderActions(array $actions): self
    {
        $this->dataObject->setData(self::KEY_HEADER_ACTIONS, $actions);
        return $this;
    }

    /**
     * @return ActionInterface[]
     */
    public function getRowActions(): array
    {
        return $this->dataObject->getData(self::KEY_ROW_ACTIONS) ?? [];
    }

    /**
     * @param ActionInterface[] $actions
     * @return $this
     */
    public function setRowActions(array $actions): self
    {
        $this->dataObject->setData(self::KEY_ROW_ACTIONS, $actions);
        return $this;
    }

    /**
     * @return ActionInterface[]
     */
    public function getBulkActions(): array
    {
        return $this->dataObject->getData(self::KEY_BULK_ACTIONS) ?? [];
    }

    /**
     * @param ActionInterface[] $actions
     * @return $this
     */
    public function setBulkActions(array $actions): self
    {
        $this->dataObject->setData(self::KEY_BULK_ACTIONS, $actions);
        return $this;
    }

    public function setHeaderActionType(string $headerActionType): self
    {
        $this->dataObject->setData(self::KEY_HEADER_ACTION_TYPE, $headerActionType);
        return $this;
    }

    public function getHeaderActionType(): ?string
    {
        return $this->dataObject->getData(self::KEY_HEADER_ACTION_TYPE);
    }

    public function setRowActionType(string $rowActionType): self
    {
        $this->dataObject->setData(self::KEY_ROW_ACTION_TYPE, $rowActionType);
        return $this;
    }

    public function getRowActionType(): ?string
    {
        return $this->dataObject->getData(self::KEY_ROW_ACTION_TYPE);
    }

    public function setBulkActionType(string $bulkActionType): self
    {
        $this->dataObject->setData(self::KEY_BULK_ACTION_TYPE, $bulkActionType);
        return $this;
    }

    public function getBulkActionType(): ?string
    {
        return $this->dataObject->getData(self::KEY_BULK_ACTION_TYPE);
    }

    /**
     * @param string[] $activeColumns
     * @return self
     */
    public function setActiveColumns(array $activeColumns): self
    {
        $this->dataObject->setData(self::KEY_ACTIVE_COLUMNS, $activeColumns);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getActiveColumns(): array
    {
        return $this->dataObject->getData(self::KEY_ACTIVE_COLUMNS) ?? [];
    }

    /**
     * @param string[] $sortableColumns
     * @return self
     */
    public function setSortableColumns(array $sortableColumns): self
    {
        $this->dataObject->setData(self::KEY_SORTABLE_COLUMNS, $sortableColumns);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getSortableColumns(): array
    {
        return $this->dataObject->getData(self::KEY_SORTABLE_COLUMNS) ?? [];
    }

    /**
     * @param string[] $filterableColumns
     * @return self
     */
    public function setFilterableColumns(array $filterableColumns): self
    {
        $this->dataObject->setData(self::KEY_FILTERABLE_COLUMNS, $filterableColumns);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFilterableColumns(): array
    {
        return $this->dataObject->getData(self::KEY_FILTERABLE_COLUMNS) ?? [];
    }

    public function isFilterEnabled(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_FILTER_ENABLED);
    }

    public function setIsFilterEnabled(bool $isFilterEnabled): self
    {
        $this->dataObject->setData(self::KEY_IS_FILTER_ENABLED, $isFilterEnabled);
        return $this;
    }

    public function setIsColumnSettingEnabled(bool $isColumnSettingEnabled): self
    {
        $this->dataObject->setData(self::KEY_IS_COLUMN_SETTING_ENABLED, $isColumnSettingEnabled);
        return $this;
    }

    public function isColumnSettingEnabled(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_COLUMN_SETTING_ENABLED);
    }

    public function setDefaultSortOrder(string $defaultSortOrder): self
    {
        $this->dataObject->setData(self::KEY_DEFAULT_SORT_ORDER, $defaultSortOrder);
        return $this;
    }

    public function getDefaultSortOrder(): ?string
    {
        return $this->dataObject->getData(self::KEY_DEFAULT_SORT_ORDER);
    }

    public function setDefaultSortField(string $defaultSortOrder): self
    {
        $this->dataObject->setData(self::KEY_DEFAULT_SORT_FIELD, $defaultSortOrder);
        return $this;
    }

    public function getDefaultSortField(): ?string
    {
        return $this->dataObject->getData(self::KEY_DEFAULT_SORT_FIELD);
    }

    public function toArray(): array
    {
        $data = $this->dataObject->toArray();

        $data[self::KEY_HEADER_ACTIONS] = [];
        foreach ($this->getHeaderActions() as $action) {
            if ($action instanceof ArrayableInterface) {
                $data[self::KEY_HEADER_ACTIONS][] = $action->toArray();
            }
        }
        $data[self::KEY_ROW_ACTIONS] = [];
        foreach ($this->getRowActions() as $action) {
            if ($action instanceof ArrayableInterface) {
                $data[self::KEY_ROW_ACTIONS][] = $action->toArray();
            }
        }
        $data[self::KEY_BULK_ACTIONS] = [];
        foreach ($this->getBulkActions() as $action) {
            if ($action instanceof ArrayableInterface) {
                $data[self::KEY_BULK_ACTIONS][] = $action->toArray();
            }
        }
        $data[self::KEY_ACTIVE_COLUMNS] = [];
        foreach ($this->getActiveColumns() as $column) {
            if (is_string($column)) {
                $data[self::KEY_ACTIVE_COLUMNS][] = $column;
            }
        }
        $data[self::KEY_SORTABLE_COLUMNS] = [];
        foreach ($this->getSortableColumns() as $column) {
            if (is_string($column)) {
                $data[self::KEY_SORTABLE_COLUMNS][] = $column;
            }
        }
        $data[self::KEY_FILTERABLE_COLUMNS] = [];
        foreach ($this->getFilterableColumns() as $column) {
            if (is_string($column)) {
                $data[self::KEY_FILTERABLE_COLUMNS][] = $column;
            }
        }
        return $data;
    }
}
