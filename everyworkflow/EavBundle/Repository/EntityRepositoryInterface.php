<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\EavBundle\Document\EntityDocumentInterface;
use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;
use MongoDB\Model\BSONDocument;

interface EntityRepositoryInterface extends BaseDocumentRepositoryInterface
{
    /**
     * @return EntityDocumentInterface
     */
    public function create(array|BSONDocument $data = []): BaseDocumentInterface;

    public function getSelectOptions(): \MongoDB\Driver\Cursor;

    public function deleteByCode(string $entityCode, array $otherFilter = []): object|array|null;
}
