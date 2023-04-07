<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\MongoSync;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SyncInterface;

class Mongo_Sync_2023_01_01_00_00_00_Catalog_Product_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function sync(): bool
    {
        $this->catalogProductRepository->getCollection()->createIndex(['status' => 1]);
        $this->catalogProductRepository->getCollection()->createIndex(['sku' => 1], ['unique' => true]);
        $this->catalogProductRepository->getCollection()->createIndex(['category' => 1]);
        $this->catalogProductRepository->getCollection()->createIndex(['updated_at' => 1]);
        return self::SUCCESS;
    }
}
