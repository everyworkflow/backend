<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\MongoSync;

use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SyncInterface;

class Mongo_Sync_2023_01_01_00_00_00_Menu_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected MenuRepositoryInterface $menuRepository
    ) {
    }

    public function sync(): bool
    {
        $this->menuRepository->getCollection()->createIndex(['status' => 1]);
        $this->menuRepository->getCollection()->createIndex(['code' => 1], ['unique' => true]);
        $this->menuRepository->getCollection()->createIndex(['updated_at' => 1]);
        return self::SUCCESS;
    }
}
