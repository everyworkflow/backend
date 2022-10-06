<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataGridBundle\Tests\Unit;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataGridBundle\Factory\ActionFactory;
use EveryWorkflow\DataGridBundle\Factory\DataGridFactory;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\Tests\BaseGridTestCase;
use EveryWorkflow\MongoBundle\Repository\BaseRepository;
use Symfony\Component\HttpFoundation\Request;

class DataGridTest extends BaseGridTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $connection = $this->getMongoConnection();
        $baseRepository = new BaseRepository($connection);
        $baseRepository->setCollectionName('data_grid_test_collection')
            ->getCollection()
            ->insertMany($this->getExampleUserData());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $connection = $this->getMongoConnection();
        $baseRepository = new BaseRepository($connection);
        $baseRepository->setCollectionName('data_grid_test_collection')
            ->getCollection()
            ->drop();
    }

    public function test_data_grid(): void
    {
        $container = self::getContainer();
        $dataObjectFactory = $this->getDataObjectFactory();
        $connection = $this->getMongoConnection();
        $baseRepository = new BaseRepository($connection);
        $testRepository = $baseRepository->setCollectionName('data_grid_test_collection');
        $formFactory = $this->getFormFactory($container);
        $actionFactory = new ActionFactory($dataObjectFactory);
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

        self::assertArrayHasKey(
            'data_collection',
            $gridData,
            'Data must contain >> data_collection << array key.'
        );
        self::assertArrayHasKey(
            'meta',
            $gridData['data_collection'],
            'Data must contain >> data_collection[meta] << array key.'
        );
        self::assertArrayHasKey(
            'results',
            $gridData['data_collection'],
            'Data must contain >> data_collection[results] << array key.'
        );
        self::assertCount(
            20,
            $gridData['data_collection']['results'],
            'Count of data_collection results must be same.'
        );

        $testIndex = 3;
        /** @var DataObjectInterface $testItem */
        $testEmail = $gridData['data_collection']['results'][$testIndex]['email'];
        $exampleUser = array_filter($exampleUserData, static fn($item) => $item['email'] === $testEmail);
        $exampleUser = $exampleUser[array_key_first($exampleUser)];
        self::assertEquals(
            $exampleUser['first_name'],
            $gridData['data_collection']['results'][$testIndex]['first_name']
        );
        self::assertEquals($exampleUser['last_name'], $gridData['data_collection']['results'][$testIndex]['last_name']);

        self::assertArrayHasKey(
            'data_grid_config',
            $gridData,
            'Data must contain >> data_grid_config << array key.'
        );
        /* TODO: Actions are not being tested yet */
        self::assertArrayHasKey(
            'active_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[active_columns] << array key.'
        );
        self::assertCount(
            count($dataGridConfig->getActiveColumns()),
            $gridData['data_grid_config']['active_columns'],
            'Count of data_grid_config active_columns must be same.'
        );
        self::assertArrayHasKey(
            'sortable_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[sortable_columns] << array key.'
        );
        self::assertCount(
            count($dataGridConfig->getSortableColumns()),
            $gridData['data_grid_config']['sortable_columns'],
            'Count of data_grid_config sortable_columns must be same.'
        );
        self::assertArrayHasKey(
            'filterable_columns',
            $gridData['data_grid_config'],
            'Data must contain >> data_grid_config[filterable_columns] << array key.'
        );
        self::assertCount(
            count($dataGridConfig->getFilterableColumns()),
            $gridData['data_grid_config']['filterable_columns'],
            'Count of data_grid_config filterable_columns must be same.'
        );
        self::assertArrayHasKey('data_form', $gridData, 'Data must contain >> data_form << array key.');
        self::assertCount(
            count($form->getFields()),
            $gridData['data_form']['fields'],
            'Count of form field and grid data form field must be same.'
        );
    }
}
