<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Repository;

use EveryWorkflow\CatalogCategoryBundle\Entity\CatalogCategoryEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;

#[EntityRepositoryAttribute(
    documentClass: CatalogCategoryEntity::class,
    primaryKey: 'path',
    entityCode: 'catalog_category'
)]
class CatalogCategoryRepository extends BaseEntityRepository implements CatalogCategoryRepositoryInterface
{
    // Something
}
