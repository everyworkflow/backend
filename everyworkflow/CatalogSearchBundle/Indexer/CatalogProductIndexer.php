<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Indexer;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\IndexerBundle\Indexer\AbstractIndexer;

class CatalogProductIndexer extends AbstractIndexer implements CatalogProductIndexerInterface
{
    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository,
        protected AttributeRepositoryInterface $attributeRepository
    ) {
    }

    public function getCode(): string
    {
        return 'catalog_product';
    }

    /**
     * Execute indexer invalid.
     */
    public function invalid(): void
    {
        $this->catalogProductRepository->getCollection()->updateMany([
            'sku' => [
                '$exists' => true,
            ],
        ], [
            '$set' => [
                'indexer.status' => 'invalid',
            ],
        ]);
    }

    /**
     * Execute indexer index.
     */
    public function index(): void
    {
        $attributes = $this->attributeRepository->find([
            'entity_code' => 'catalog_product',
        ]);
        foreach ($attributes as $attribute) {
        }
        $this->catalogProductRepository->getCollection();
        echo 'Indexer index from catalog product 123'.PHP_EOL;
    }
}
