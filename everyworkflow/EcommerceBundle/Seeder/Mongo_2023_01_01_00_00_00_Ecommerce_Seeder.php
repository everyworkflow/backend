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
    protected array $categories = [];

    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function seed(): bool
    {
        $this->seedCategories();
        $this->seedProducts();

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->catalogCategoryRepository->getCollection()->drop();
        $this->catalogProductRepository->getCollection()->drop();

        return self::SUCCESS;
    }

    protected function seedCategories(): void
    {
        for ($i = 1; $i < 50; ++$i) {
            $this->categories[] = [
                'status' => 'enable',
                'name' => 'Category - ' . $i,
                'code' => 'category-' . $i,
                'path' => 'category-' . $i,
            ];
        }

        foreach ($this->categories as $item) {
            $document = $this->catalogCategoryRepository->create($item);
            $this->catalogCategoryRepository->saveOne($document);
        }
    }

    protected function seedProducts(): void
    {
        $itemData = [];

        $categoryLength = count($this->categories);

        for ($i = 1; $i < 5000; ++$i) {
            $categoryIndex = rand(0, $categoryLength - 1);
            $category = $this->categories[$categoryIndex] ?? [];

            $itemData[] = [
                'status' => 'enable',
                'name' => 'Product Name - ' . $i,
                'sku' => 'sku-' . $i,
                'category' => $category['code'] ?? '',
                'price' => 5 * $i,
                'quantity' => 1000 + $i,
                'short_description' => 'This is just a short description. ' . $i,
                'description' => 'This is just a description. ' . $i,
                'meta_title' => 'Product Name - ' . $i,
                'url_key' => 'sku-' . $i,
            ];
        }

        foreach ($itemData as $item) {
            $document = $this->catalogProductRepository->create($item);
            $this->catalogProductRepository->saveOne($document);
        }
    }
}
