<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Repository;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Repository\HelperTrait\AttributeGroupHelperTrait;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;

#[EntityRepositoryAttribute(
    documentClass: CatalogProductEntity::class,
    primaryKey: 'sku',
    entityCode: 'catalog_product'
)]
class CatalogProductRepository extends BaseEntityRepository implements CatalogProductRepositoryInterface
{
    use AttributeGroupHelperTrait;
}
