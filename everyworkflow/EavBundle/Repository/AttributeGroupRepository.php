<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\EavBundle\Document\AttributeGroupDocument;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;

#[RepositoryAttribute(
    documentClass: AttributeGroupDocument::class,
    primaryKey: ['code']
)]
class AttributeGroupRepository extends BaseDocumentRepository implements AttributeGroupRepositoryInterface
{
    // Something
}
