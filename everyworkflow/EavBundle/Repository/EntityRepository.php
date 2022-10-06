<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Document\EntityDocumentInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;

#[RepositoryAttribute(documentClass: EntityDocument::class, primaryKey: 'code')]
class EntityRepository extends BaseDocumentRepository implements EntityRepositoryInterface
{
    /**
     * @return array|object|null
     */
    public function deleteByCode(string $entityCode, array $otherFilter = []): object | array | null
    {
        return $this->deleteByFilter(array_merge(['code' => $entityCode], $otherFilter));
    }

    /**
     * @psalm-return \MongoDB\Driver\Cursor<array|object>
     */
    public function getSelectOptions(): \MongoDB\Driver\Cursor
    {
        return $this->getCollection()->find(['status' => EntityDocumentInterface::STATUS_ENABLE]);
    }
}
