<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;
use EveryWorkflow\StaticBlockBundle\Document\StaticBlockDocument;

#[RepositoryAttribute(documentClass: StaticBlockDocument::class, primaryKey: 'block_key')]
class StaticBlockRepository extends BaseDocumentRepository implements StaticBlockRepositoryInterface
{
    // Something
}
