<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\DataGrid;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\BulkAction\ButtonBulkAction;
use EveryWorkflow\DataGridBundle\Factory\ActionFactoryInterface;
use EveryWorkflow\DataGridBundle\HeaderAction\ButtonHeaderAction;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\RowAction\ButtonRowAction;
use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;

class PageDataGrid extends DataGrid implements PageDataGridInterface
{
    protected DataObjectFactoryInterface $dataObjectFactory;
    protected PageRepositoryInterface $pageRepository;
    protected ActionFactoryInterface $actionFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        DataGridConfigInterface $dataGridConfig,
        FormInterface $form,
        ArraySourceInterface $source,
        DataObjectFactoryInterface $dataObjectFactory,
        PageRepositoryInterface $pageRepository,
        ActionFactoryInterface $actionFactory,
    ) {
        parent::__construct($dataObject, $dataGridConfig, $form, $source);
        $this->dataObjectFactory = $dataObjectFactory;
        $this->pageRepository = $pageRepository;
        $this->actionFactory = $actionFactory;
    }

    public function getConfig(): DataGridConfigInterface
    {
        $config = parent::getConfig();

        /** @var string[] $allColumns */
        $allColumns = array_merge(
            ['_id'],
            array_map(static fn ($attribute) => $attribute->getCode(), $this->pageRepository->getAttributes()),
            ['status', 'created_at', 'updated_at']
        );
        foreach ($allColumns as $key => $column) {
            if (str_starts_with($column, 'meta_')) {
                unset($allColumns[$key]);
            }
        }

        $config->setIsFilterEnabled(true)
            ->setIsColumnSettingEnabled(true)
            ->setActiveColumns($allColumns)
            ->setSortableColumns($allColumns)
            ->setFilterableColumns($allColumns);

        $config->setHeaderActions([
            $this->actionFactory->create(ButtonHeaderAction::class, [
                'button_path' => '/cms/page/create',
                'button_label' => 'Create new',
                'button_type' => 'primary',
            ]),
        ]);

        $config->setRowActions([
            $this->actionFactory->create(ButtonRowAction::class, [
                'button_path' => '/cms/page/{_id}/edit',
                'button_label' => 'Edit',
                'button_type' => 'primary',
            ]),
            $this->actionFactory->create(ButtonRowAction::class, [
                'button_path' => '/cms/page/{_id}',
                'button_label' => 'Delete',
                'button_type' => 'primary',
                'path_type' => ButtonRowAction::PATH_TYPE_DELETE_CALL,
                'is_danger' => true,
                'is_confirm' => true,
                'confirm_message' => 'Are you sure, you want to delete this item?',
            ]),
        ]);

        $config->setBulkActions([
            $this->actionFactory->create(ButtonBulkAction::class, [
                'button_label' => 'Enable',
                'button_path' => '/cms/page/bulk-action/enable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
            $this->actionFactory->create(ButtonBulkAction::class, [
                'button_label' => 'Disable',
                'button_path' => '/cms/page/bulk-action/disable',
                'button_type' => 'default',
                'path_type' => ButtonBulkAction::PATH_TYPE_POST_CALL,
            ]),
        ]);

        return $config;
    }

    public function getForm(): FormInterface
    {
        return $this->pageRepository->getForm();
    }
}
