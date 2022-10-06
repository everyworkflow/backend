<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;
use EveryWorkflow\SettingBundle\Document\SettingDocument;
use EveryWorkflow\SettingBundle\Document\SettingDocumentInterface;

#[RepositoryAttribute(documentClass: SettingDocument::class, primaryKey: 'code')]
class SettingDocumentRepository extends BaseDocumentRepository implements SettingDocumentRepositoryInterface
{
    public function findByCode(string $code): ?SettingDocumentInterface
    {
        return $this->findOne(['code' => $code]);
    }
}
