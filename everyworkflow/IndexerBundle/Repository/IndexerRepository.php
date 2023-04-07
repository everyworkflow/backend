<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;
use EveryWorkflow\IndexerBundle\Document\IndexerDocument;

#[RepositoryAttribute(documentClass: IndexerDocument::class)]
class IndexerRepository extends BaseDocumentRepository implements IndexerRepositoryInterface
{
    // Something
}
