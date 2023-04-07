<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Repository;

use EveryWorkflow\CatalogCategoryBundle\Entity\CatalogCategoryEntity;
use EveryWorkflow\CoreBundle\Factory\ValidatorFactoryInterface;
use EveryWorkflow\CoreBundle\Helper\CoreHelperInterface;
use EveryWorkflow\CoreBundle\Model\SystemDateTimeInterface;
use EveryWorkflow\EavBundle\Form\EntityAttributeFormInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\MongoBundle\Factory\DocumentFactoryInterface;
use EveryWorkflow\MongoBundle\Model\MongoConnectionInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[EntityRepositoryAttribute(
    documentClass: CatalogCategoryEntity::class,
    primaryKey: 'path',
    entityCode: 'catalog_category'
)]
class CatalogCategoryRepository extends BaseEntityRepository implements CatalogCategoryRepositoryInterface
{
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        EntityAttributeFormInterface $entityAttributeForm,
        DocumentFactoryInterface $documentFactory,
        CoreHelperInterface $coreHelper,
        SystemDateTimeInterface $systemDateTime,
        ValidatorFactoryInterface $validatorFactory,
        EventDispatcherInterface $eventDispatcher,
        MongoConnectionInterface $mongoConnection,
        string $collectionName = '',
        string|array $primaryKey = '',
        array $indexKeys = [],
        string $eventPrefix = '',
        ?string $documentClass = null,
        string $entityCode = '',
        array $entityAttributes = []
    ) {
        parent::__construct(
            $attributeRepository,
            $entityAttributeForm,
            $documentFactory,
            $coreHelper,
            $systemDateTime,
            $validatorFactory,
            $eventDispatcher,
            $mongoConnection,
            $collectionName,
            $primaryKey,
            $indexKeys,
            $eventPrefix,
            $documentClass
        );
    }
}
