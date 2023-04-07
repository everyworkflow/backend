<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataGridBundle\Tests\Unit;

use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFactory;
use EveryWorkflow\DataGridBundle\Factory\ActionFactory;
use EveryWorkflow\DataGridBundle\Factory\DataGridFactory;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use Symfony\Component\HttpFoundation\Request;

class ArrayDataGridTest extends AbstractDataGrid
{
    public function testArrayDataGrid(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var DataObjectFactory $dataObjectFactory */
        $dataObjectFactory = $container->get(DataObjectFactory::class);
        /** @var FormFactory $formFactory */
        $formFactory = $container->get(FormFactory::class);
        /** @var ActionFactory $actionFactory */
        $actionFactory = $container->get(ActionFactory::class);
        /** @var DataGridFactory $dataGridFactory */
        $dataGridFactory = $container->get(DataGridFactory::class);

        $dataGridConfig = $dataGridFactory->createConfig([
            DataGridConfigInterface::KEY_ACTIVE_COLUMNS => ['first_name', 'last_name'],
            DataGridConfigInterface::KEY_SORTABLE_COLUMNS => ['first_name', 'last_name'],
            DataGridConfigInterface::KEY_FILTERABLE_COLUMNS => ['first_name', 'last_name'],
        ]);
        $form = $this->getExampleUserForm($container);

        $results = [
            $dataObjectFactory->create([
                'id' => 1,
                'name' => 'Examples Name 1',
                'gender' => 'male',
            ]),
            $dataObjectFactory->create([
                'id' => 2,
                'name' => 'Examples Name 2',
                'gender' => 'female',
            ]),
            $dataObjectFactory->create([
                'id' => 3,
                'name' => 'Examples Name 3',
                'gender' => 'other',
            ]),
            $dataObjectFactory->create([
                'id' => 4,
                'name' => 'Examples Name 4',
                'gender' => 'male',
            ]),
        ];

        $dataGrid = $dataGridFactory->create(
            $results,
            $dataGridConfig,
            null,
            $form
        );

        $gridData = $dataGrid->setFromRequest(new Request(['for' => 'data-grid']))->toArray();

        $this->assertArrayHasKey(
            'data_collection',
            $gridData,
            'Data must contain >> data_collection << array key.'
        );
        $this->assertArrayHasKey(
            'meta',
            $gridData['data_collection'],
            'Data must contain >> data_collection[meta] << array key.'
        );
        $this->assertArrayHasKey(
            'results',
            $gridData['data_collection'],
            'Data must contain >> data_collection[results] << array key.'
        );
        $this->assertCount(
            count($results),
            $gridData['data_collection']['results'],
            'Count of data_collection results must be same.'
        );

        /** @var DataObjectInterface $firstItem */
        $firstItem = $results[0];
        $this->assertEquals($firstItem->getData('id'), $gridData['data_collection']['results'][0]['id']);
        $this->assertEquals($firstItem->getData('name'), $gridData['data_collection']['results'][0]['name']);
        $this->assertEquals($firstItem->getData('gender'), $gridData['data_collection']['results'][0]['gender']);

        $this->assertArrayHasKey(
            'data_grid_config',
            $gridData,
            'Data must contain >> data_grid_config << array key.'
        );
        $this->assertArrayHasKey(
            'active_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[active_columns] << array key.'
        );
        $this->assertCount(
            count($dataGridConfig->getActiveColumns()),
            $gridData['data_grid_config']['active_columns'],
            'Count of data_grid_config active_columns must be same.'
        );
        $this->assertArrayHasKey(
            'sortable_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[sortable_columns] << array key.'
        );
        $this->assertCount(
            count($dataGridConfig->getSortableColumns()),
            $gridData['data_grid_config']['sortable_columns'],
            'Count of data_grid_config sortable_columns must be same.'
        );
        $this->assertArrayHasKey(
            'filterable_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[filterable_columns] << array key.'
        );
        $this->assertCount(
            count($dataGridConfig->getFilterableColumns()),
            $gridData['data_grid_config']['filterable_columns'],
            'Count of data_grid_config filterable_columns must be same.'
        );
        $this->assertArrayHasKey(
            'data_form',
            $gridData,
            'Data must contain >> data_form << array key.'
        );
        $this->assertCount(
            count($form->getFields()),
            $gridData['data_form']['fields'],
            'Count of form field and grid data form field must be same.'
        );
    }
}
