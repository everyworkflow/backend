<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;
use EveryWorkflow\SettingBundle\Document\SettingDocumentInterface;

interface SettingDocumentRepositoryInterface extends BaseDocumentRepositoryInterface
{
    public function findByCode(string $code): ?SettingDocumentInterface;
}
