<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EcommerceBundle\Seeder;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SeederInterface;

class Mongo_2023_01_01_00_00_00_Ecommerce_Seeder implements SeederInterface
{
    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function seed(): bool
    {
        $itemData = [];

        for ($i = 1; $i < 5000; ++$i) {
            $itemData[] = [
                'status' => 'enable',
                'name' => 'Product Name - '.$i,
                'sku' => 'sku-'.$i,
                'price' => 5 * $i,
                'quantity' => 1000 + $i,
                'short_description' => 'This is just a short description. '.$i,
                'description' => 'This is just a description. '.$i,
                'meta_title' => 'Product Name - '.$i,
                'url_key' => 'sku-'.$i,
            ];
        }

        foreach ($itemData as $item) {
            $product = $this->catalogProductRepository->create($item);
            $this->catalogProductRepository->saveOne($product);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->catalogProductRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
