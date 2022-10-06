<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\GridConfig;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataGridBundle\BulkAction\ButtonBulkAction;
use EveryWorkflow\DataGridBundle\Factory\ActionFactoryInterface;
use EveryWorkflow\DataGridBundle\HeaderAction\ButtonHeaderAction;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use EveryWorkflow\DataGridBundle\RowAction\ButtonRowAction;

class AttributeGridConfig extends DataGridConfig implements AttributeGridConfigInterface
{
    protected const GRID_COLUMNS =
    [
        '_id',
        'code',
        'name',
        'status',
        'entity_code',
        'type',
        'class',
        'is_required',
        'is_readonly',
        'is_used_in_grid',
        'is_used_in_form',
        'sort_order',
        'created_at',
        'updated_at'
    ];

    public function __construct(
        DataObjectInterface $dataObject,
        ActionFactoryInterface $actionFactory
    ) {
        parent::__construct($dataObject, $actionFactory);
        $this->dataObject->setDataIfNot(self::KEY_IS_FILTER_ENABLED, true);
        $this->dataObject->setDataIfNot(self::KEY_IS_COLUMN_SETTING_ENABLED, true);
    }

    public function getActiveColumns(): array
    {
        return array_merge(self::GRID_COLUMNS, parent::getActiveColumns());
    }

    public function getSortableColumns(): array
    {
        return array_merge(self::GRID_COLUMNS, parent::getSortableColumns());
    }

    public function getFilterableColumns(): array
    {
        return array_merge(self::GRID_COLUMNS, parent::getFilterableColumns());
    }

    public function getHeaderActions(): array
    {
        $headerActions = [
            $this->getActionFactory()->create(ButtonHeaderAction::class, [
                'button_label' => 'Create new',
                'button_path' => '/system/attribute/create',
                'button_type' => 'primary',
            ]),
        ];
        return array_merge($headerActions, parent::getHeaderActions());
    }

    public function getRowActions(): array
    {
        $rowActions = [
            $this->getActionFactory()->create(ButtonRowAction::class, [
                'button_label' => 'Edit',
                'button_path' => '/system/attribute/{code}/edit',
                'button_type' => 'primary',
            ]),
            $this->getActionFactory()->create(ButtonRowAction::class, [
                'button_label' => 'Delete',
                'button_path' => '/eav/attribute/{code}',
                'button_type' => 'primary',
                'path_type' => ButtonRowAction::PATH_TYPE_DELETE_CALL,
                'is_danger' => true,
                'is_confirm' => true,
                'confirm_message' => 'Are you sure, you want to delete this item?',
            ]),
        ];
        return array_merge($rowActions, parent::getBulkActions());
    }

    public function getBulkActions(): array
    {
        $bulkActions = [
            $this->getActionFactory()->create(ButtonBulkAction::class, [
                'button_label' => 'Enable',
                'button_path' => '/eav/attribute/bulk-action/enable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
            $this->getActionFactory()->create(ButtonBulkAction::class, [
                'button_label' => 'Disable',
                'button_path' => '/eav/attribute/bulk-action/disable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
        ];
        return array_merge($bulkActions, parent::getBulkActions());
    }
}
