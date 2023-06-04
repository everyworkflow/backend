<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Repository;

use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\PageBundle\Entity\PageEntity;

#[EntityRepositoryAttribute(
    documentClass: PageEntity::class,
    primaryKey: 'url_path',
    entityCode: 'page'
)]
class PageRepository extends BaseEntityRepository implements PageRepositoryInterface
{
    // Something
}
