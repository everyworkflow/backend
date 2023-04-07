<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Attribute;

use EveryWorkflow\CoreBundle\Helper\CoreHelper;
use EveryWorkflow\CoreBundle\Helper\CoreHelperInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactory;
use EveryWorkflow\DataGridBundle\Factory\ActionFactory;
use EveryWorkflow\DataGridBundle\Factory\DataGridFactory;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFactory;
use EveryWorkflow\EavBundle\Factory\AttributeFactoryInterface;
use EveryWorkflow\EavBundle\Form\AttributeForm;
use EveryWorkflow\EavBundle\GridConfig\AttributeGridConfig;
use EveryWorkflow\EavBundle\Model\EavConfigProvider;
use EveryWorkflow\EavBundle\Model\EavConfigProviderInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepository;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepository;
use EveryWorkflow\MongoBundle\Factory\DocumentFactory;
use EveryWorkflow\MongoBundle\Model\MongoConnection;
use EveryWorkflow\MongoBundle\Model\MongoConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class AttributeCrudTest extends KernelTestCase
{
    protected EavConfigProviderInterface $eavConfigProvider;
    protected AttributeFactoryInterface $attributeFactory;
    protected AttributeRepositoryInterface $attributeRepository;
    protected MongoConnectionInterface $mongoConnection;

    protected array $testAttributeData = [];

    protected function getNewCoreHelper(): CoreHelperInterface
    {
        $coreHelper = $this->getMockBuilder(CoreHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @var CoreHelperInterface $coreHelper */
        return $coreHelper;
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $container = self::getContainer();

        $this->mongoConnection = $container->get(MongoConnection::class);
        $this->eavConfigProvider = $container->get(EavConfigProvider::class);
        $this->attributeFactory = $container->get(AttributeFactory::class);
        $this->attributeRepository = $container->get(AttributeRepository::class);

        for ($i = 1; $i < 50; ++$i) {
            $this->testAttributeData[] = $this->attributeFactory->createAttribute([
                'code' => 'attr_'.$i,
                'name' => 'Test attribute '.$i,
                'entity_code' => 'test_entity_crud',
                'type' => 'text_attribute',
                'sort_order' => $i,
            ]);
        }
        foreach ($this->testAttributeData as $item) {
            $this->attributeRepository->saveOne($item);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->attributeRepository->getCollection()->drop();
    }

    public function testListPageWithPagination(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var DataObjectFactory $dataObjectFactory */
        $dataObjectFactory = $container->get(DataObjectFactory::class);
        /** @var FormSectionFactory $formSectionFactory */
        $formSectionFactory = $container->get(FormSectionFactory::class);
        /** @var FormFieldFactory $formFieldFactory */
        $formFieldFactory = $container->get(FormFieldFactory::class);
        /** @var FieldOptionFactory $fieldOptionFactory */
        $fieldOptionFactory = $container->get(FieldOptionFactory::class);
        /** @var ActionFactory $actionFactory */
        $actionFactory = $container->get(ActionFactory::class);
        /** @var FormFactory $formFactory */
        $formFactory = $container->get(FormFactory::class);
        $dataGridConfig = new AttributeGridConfig($dataObjectFactory->create(), $actionFactory);
        $dataGridFactory = new DataGridFactory($formFactory, $dataObjectFactory, $actionFactory);

        $parameter = $dataGridFactory->createParameter([
            'sort' => [
                '_id' => -1,
            ],
            'limit' => 20,
        ], [
            'entity_code' => 'test_entity_crud',
        ]);

        /** @var DocumentFactory $documentFactory */
        $documentFactory = $container->get(DocumentFactory::class);
        /** @var EntityRepository $entityRepository */
        $entityRepository = $container->get(EntityRepository::class);
        /** @var AttributeForm $form */
        $form = $container->get(AttributeForm::class);

        $dataGrid = $dataGridFactory->create($this->attributeRepository, $dataGridConfig, $parameter, $form);
        $gridData = $dataGrid->setFromRequest(new Request(['for' => 'data-grid']))->toArray();

        $this->assertIsBool(
            count($this->testAttributeData) <= count($gridData['data_collection']['results']),
            'Data grid result count must be same.'
        );

        $this->assertArrayHasKey('data_collection', $gridData, 'Data must contain >> data_collection << array key.');
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
            count($this->testAttributeData) < 20 ? count($this->testAttributeData) : 20,
            $gridData['data_collection']['results'],
            'Count of data_collection results must be same.'
        );

        $testIndex = 2;
        /** @var DataObjectInterface $testItem */
        $testCode = $gridData['data_collection']['results'][$testIndex]['code'];
        $exampleAttrs = array_filter(
            $this->testAttributeData,
            static fn (BaseAttributeInterface $item) => $item->getCode() === $testCode
        );
        /** @var BaseAttributeInterface $exampleAttr */
        $exampleAttr = $exampleAttrs[array_key_first($exampleAttrs)];
        $this->assertEquals($exampleAttr->getCode(), $gridData['data_collection']['results'][$testIndex]['code']);
        $this->assertEquals($exampleAttr->getName(), $gridData['data_collection']['results'][$testIndex]['name']);
        $this->assertEquals(
            $exampleAttr->getEntityCode(),
            $gridData['data_collection']['results'][$testIndex]['entity_code']
        );
        $this->assertEquals($exampleAttr->getType(), $gridData['data_collection']['results'][$testIndex]['type']);

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

        $this->assertArrayHasKey('data_form', $gridData, 'Data must contain >> data_form << array key.');
        $this->assertCount(
            count($form->getFields()),
            $gridData['data_form']['fields'],
            'Count of form field and grid data form field must be same.'
        );
    }
}
