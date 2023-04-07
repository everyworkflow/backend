<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\MongoSync;

use EveryWorkflow\MongoBundle\Support\SyncInterface;
use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;

class Mongo_Sync_2023_01_01_00_00_00_Page_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {
    }

    public function sync(): bool
    {
        $this->pageRepository->getCollection()->createIndex(['status' => 1]);
        $this->pageRepository->getCollection()->createIndex(['url_path' => 1], ['unique' => true]);
        $this->pageRepository->getCollection()->createIndex(['updated_at' => 1]);
        return self::SUCCESS;
    }
}
