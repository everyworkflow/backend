<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\MongoSync;

use EveryWorkflow\MongoBundle\Support\SyncInterface;
use EveryWorkflow\StaticBlockBundle\Repository\StaticBlockRepositoryInterface;

class Mongo_Sync_2023_01_01_00_00_00_Static_Block_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected StaticBlockRepositoryInterface $staticBlockRepository
    ) {
    }

    public function sync(): bool
    {
        $this->staticBlockRepository->getCollection()->createIndex(['status' => 1]);
        $this->staticBlockRepository->getCollection()->createIndex(['block_key' => 1], ['unique' => true]);
        $this->staticBlockRepository->getCollection()->createIndex(['updated_at' => 1]);
        return self::SUCCESS;
    }
}
