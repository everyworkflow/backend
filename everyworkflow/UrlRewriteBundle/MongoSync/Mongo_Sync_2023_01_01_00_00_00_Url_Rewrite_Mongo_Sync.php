<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\MongoSync;

use EveryWorkflow\MongoBundle\Support\SyncInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;

class Mongo_Sync_2023_01_01_00_00_00_Url_Rewrite_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
    }

    public function sync(): bool
    {
        $this->urlRewriteRepository->getCollection()->createIndex(['status' => 1]);
        $this->urlRewriteRepository->getCollection()->createIndex(['url' => 1], ['unique' => true]);
        $this->urlRewriteRepository->getCollection()->createIndex(['updated_at' => 1]);

        return self::SUCCESS;
    }
}
