<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;
use EveryWorkflow\CronBundle\Document\CronJobDocument;

#[RepositoryAttribute(documentClass: CronJobDocument::class, primaryKey: 'code')]
class CronJobRepository extends BaseDocumentRepository implements CronJobRepositoryInterface
{
    // Something
}
