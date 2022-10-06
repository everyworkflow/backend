<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Entity;

use EveryWorkflow\CoreBundle\Helper\CoreHelper;
use EveryWorkflow\CoreBundle\Model\SystemDateTime;
use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\EavBundle\Factory\AttributeFieldFactory;
use EveryWorkflow\EavBundle\Form\EntityAttributeForm;
use EveryWorkflow\EavBundle\Repository\AttributeRepository;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Tests\Unit\BaseEavTestCase;
use EveryWorkflow\MongoBundle\Factory\DocumentFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EntityMustBeUniqueTest extends BaseEavTestCase
{
    public function testMultipleEntityInstancesMustBeUnique(): void
    {
        $container = parent::getContainer();
        /** @var CoreHelper $coreHelper */
        $coreHelper = $this->getMockBuilder(CoreHelper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $documentFactory = new DocumentFactory($this->getDataObjectFactory());
        $attributeRepository = new AttributeRepository(
            $documentFactory,
            $coreHelper,
            new SystemDateTime($this->getCoreConfigProvider()),
            $this->getValidatorFactory(),
            new EventDispatcher(),
            $this->getMongoConnection()
        );
        /** @var AttributeFieldFactory $attributeFieldFactory */
        $attributeFieldFactory = $this->getMockBuilder(AttributeFieldFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fieldOptionFactory = new FieldOptionFactory($this->getDataObjectFactory());
        $entityAttributeForm = new EntityAttributeForm(
            $this->getDataObjectFactory()->create(),
            $this->getFormSectionFactory($container),
            $this->getFormFieldFactory($container),
            $attributeFieldFactory,
            $fieldOptionFactory,
        );

        /* Setting up test entity 1 object */
        $test1DocRepository = new BaseEntityRepository(
            $attributeRepository,
            $entityAttributeForm,
            $documentFactory,
            $coreHelper,
            new SystemDateTime($this->getCoreConfigProvider()),
            $this->getValidatorFactory(),
            new EventDispatcher(),
            $this->getMongoConnection()
        );
        $test1DocRepository->setCollectionName('test_1_entity');

        /* Setting up another test entity 2 object */
        $test2DocRepository = new BaseEntityRepository(
            $attributeRepository,
            $entityAttributeForm,
            $documentFactory,
            $coreHelper,
            new SystemDateTime($this->getCoreConfigProvider()),
            $this->getValidatorFactory(),
            new EventDispatcher(),
            $this->getMongoConnection()
        );
        $test2DocRepository->setCollectionName('test_2_entity');

        /* Testing if document repository of multiple entity objects has clean dependencies */
        self::assertEquals(
            'test_1_entity',
            $test1DocRepository->getCollectionName(),
            'Entity 1 collection name must be valid and unique',
        );
        self::assertEquals(
            'test_2_entity',
            $test2DocRepository->getCollectionName(),
            'Entity 2 collection name must be valid and unique',
        );
    }
}
