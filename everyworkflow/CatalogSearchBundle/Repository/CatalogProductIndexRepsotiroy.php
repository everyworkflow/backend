<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Repository;

use EveryWorkflow\CatalogSearchBundle\Document\CatalogProductIndexDocument;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;

#[RepositoryAttribute(documentClass: CatalogProductIndexDocument::class, primaryKey: 'sku')]
class CatalogProductIndexRepsotiroy extends BaseDocumentRepository implements CatalogProductIndexRepsotiroyInterface
{
    // Something
}
