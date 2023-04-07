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
use EveryWorkflow\MongoBundle\Model\MongoConnection;
use EveryWorkflow\MongoBundle\Repository\BaseRepository;
use Symfony\Component\HttpFoundation\Request;

class DataGridTest extends AbstractDataGrid
{
    public const COLLECTION_NAME = 'data_grid_test_collection';

    protected function setUp(): void
    {
        parent::setUp();

        $container = self::getContainer();
        /** @var MongoConnection $connection */
        $connection = $container->get(MongoConnection::class);
        $baseRepository = new BaseRepository($connection, self::COLLECTION_NAME);
        $baseRepository->getCollection()->insertMany($this->getExampleUserData());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $container = self::getContainer();
        /** @var MongoConnection $connection */
        $connection = $container->get(MongoConnection::class);
        $baseRepository = new BaseRepository($connection, self::COLLECTION_NAME);
        $baseRepository->getCollection()->drop();
    }

    public function testDataGrid(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var DataObjectFactory $dataObjectFactory */
        $dataObjectFactory = $container->get(DataObjectFactory::class);
        /** @var MongoConnection $connection */
        $connection = $container->get(MongoConnection::class);
        $testRepository = new BaseRepository($connection, self::COLLECTION_NAME);
        /** @var FormFactory $formFactory */
        $formFactory = $container->get(FormFactory::class);
        /** @var ActionFactory $actionFactory */
        $actionFactory = $container->get(ActionFactory::class);
        $dataGridFactory = new DataGridFactory($formFactory, $dataObjectFactory, $actionFactory);

        $columnNames = ['_id', 'first_name', 'last_name', 'email'];
        $dataGridConfig = $dataGridFactory->createConfig([
            DataGridConfigInterface::KEY_ACTIVE_COLUMNS => $columnNames,
            DataGridConfigInterface::KEY_SORTABLE_COLUMNS => $columnNames,
            DataGridConfigInterface::KEY_FILTERABLE_COLUMNS => $columnNames,
        ]);
        $parameter = $dataGridFactory->createParameter(options: [
            'sort' => [
                '_id' => -1,
            ],
        ]);
        $form = $this->getExampleUserForm($container);

        $dataGrid = $dataGridFactory->create($testRepository, $dataGridConfig, $parameter, $form);
        $gridData = $dataGrid->setFromRequest(new Request(['for' => 'data-grid']))->toArray();

        $exampleUserData = $this->getExampleUserData();

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
            20,
            $gridData['data_collection']['results'],
            'Count of data_collection results must be same.'
        );

        $testIndex = 3;
        /** @var DataObjectInterface $testItem */
        $testEmail = $gridData['data_collection']['results'][$testIndex]['email'];
        $exampleUser = array_filter($exampleUserData, static fn ($item) => $item['email'] === $testEmail);
        $exampleUser = $exampleUser[array_key_first($exampleUser)];
        $this->assertEquals(
            $exampleUser['first_name'],
            $gridData['data_collection']['results'][$testIndex]['first_name']
        );
        $this->assertEquals($exampleUser['last_name'], $gridData['data_collection']['results'][$testIndex]['last_name']);

        $this->assertArrayHasKey(
            'data_grid_config',
            $gridData,
            'Data must contain >> data_grid_config << array key.'
        );
        /* TODO: Actions are not being tested yet */
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
        $this->assertArrayHasKey('data_form', $gridData, 'Data must contain >> data_form << array key.');
        $this->assertCount(
            count($form->getFields()),
            $gridData['data_form']['fields'],
            'Count of form field and grid data form field must be same.'
        );
    }
}
