<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\MongoSync;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SyncInterface;

class Mongo_Sync_2023_01_01_00_00_00_Catalog_Category_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository
    ) {
    }
    
    public function sync(): bool
    {
        $this->catalogCategoryRepository->getCollection()->createIndex(['status' => 1]);
        $this->catalogCategoryRepository->getCollection()->createIndex(['code' => 1], ['unique' => true]);
        $this->catalogCategoryRepository->getCollection()->createIndex(['updated_at' => 1]);

        return self::SUCCESS;
    }
}
