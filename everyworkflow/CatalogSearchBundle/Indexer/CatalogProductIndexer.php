<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Indexer;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Document\AttributeDocumentInterface;
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
        return 'catalog_product_indexer';
    }

    /**
     * Execute indexer invalid.
     */
    public function invalid(): bool
    {
        $this->catalogProductRepository->getCollection()->updateMany([
            'sku' => [
                '$exists' => true,
            ],
        ], [
            '$set' => [
                'indexer.index_status.catalog_product_indexer' => 'invalid',
            ],
        ]);

        return self::SUCCESS;
    }

    /**
     * Execute indexer index.
     */
    public function index(): bool
    {
        // Setting invalid for new products
        $this->catalogProductRepository->getCollection()->updateMany([
                'indexer.index_status.catalog_product_indexer' => ['$exists' => false],
            ], [
                '$set' => [
                    'indexer.index_status.catalog_product_indexer' => 'invalid',
                ],
            ]);

        // Checking if any product is invalid
        try {
            $isIndexInvalid = $this->catalogProductRepository->getCollection()->findOne([
                'indexer.index_status.catalog_product_indexer' => 'invalid',
            ]);
        } catch (\Exception $e) {
            $isIndexInvalid = null;
        }
        if (!$isIndexInvalid && !$this->isForced()) {
            echo '- Everything seems indexed.';
            echo PHP_EOL;

            return self::SUCCESS;
        }

        // Index attribute wise
        $attributes = $this->catalogProductRepository->getAttributes();
        foreach ($attributes as $attribute) {
            try {
                $this->indexAttribute($attribute);
            } catch (\Exception $e) {
                echo '- Error: attribute index error | Code: '.$attribute->getCode.' | Message: '.$e->getMessage();
                echo PHP_EOL;
            }
        }

        // Index attribute wise
        $this->catalogProductRepository->getCollection()
            ->updateMany(
                [
                    'indexer.index_status.catalog_product_indexer' => 'invalid',
                ],
                [
                    '$set' => [
                        'indexer.index_status.catalog_product_indexer' => 'indexed',
                    ],
                ]
            );

        return self::SUCCESS;
    }

    protected function indexAttribute(AttributeDocumentInterface $attribute): void
    {
        switch ($attribute->getType()) {
            case 'select_attribute':
                $this->indexSelectAttribute($attribute);
                echo '- Success: attribute_indexed | Code: '.$attribute->getCode().' | Type: '.$attribute->getType();
                echo PHP_EOL;
                break;
            default:
                echo '- Info: attribute_skipped | Code: '.$attribute->getCode().' | Type: '.$attribute->getType();
                echo PHP_EOL;
        }
    }

    protected function indexSelectAttribute(AttributeDocumentInterface $attribute): void
    {
        $options = $attribute->getData('options');
        foreach ($options as $option) {
            $filter = [
                'indexer.index_status.catalog_product_indexer' => 'invalid',
            ];
            $filter[$attribute->getCode()] = $option['code'];

            $updateData = [];
            $updateData['indexer.attribute.'.$attribute->getCode()] = $option['code'];
            $updateData['indexer.attribute_label.'.$attribute->getCode()] = $option['label'];
            $update = [
                '$set' => $updateData,
            ];

            try {
                $result = $this->catalogProductRepository->getCollection()->updateMany($filter, $update);
                echo '-- Success: attribute_option_index | Code: '.$option['code'].' | Matched Count: '.$result->getMatchedCount().' | Modified Count: '.$result->getModifiedCount();
                echo PHP_EOL;
            } catch (\Exception $e) {
                echo '-- Error: attribute_option_index | Code: '.$option['code'].' | Error: '.$e->getMessage();
            }
        }
    }
}
