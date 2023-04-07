<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Migration;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntity;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_05_00_00_00_CatalogProduct_Migration implements MigrationInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $productEntity */
        $productEntity = $this->entityRepository->create();
        $productEntity
            ->setName('Catalog product')
            ->setCode($this->catalogProductRepository->getEntityCode())
            ->setClass(CatalogProductEntity::class)
            ->setStatus(CatalogProductEntity::STATUS_ENABLE);
        $this->entityRepository->saveOne($productEntity);

        $attributeData = [
            [
                'code' => 'sku',
                'name' => 'Sku',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'name',
                'name' => 'Name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'price',
                'name' => 'Price',
                'type' => 'currency_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'special_price_from',
                'name' => 'Special Price From',
                'type' => 'date_time_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
            ],
            [
                'code' => 'special_price',
                'name' => 'Special Price',
                'type' => 'currency_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
            ],
            [
                'code' => 'special_price_to',
                'name' => 'Special Price To',
                'type' => 'date_time_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
            ],
            [
                'code' => 'quantity',
                'name' => 'Quantity',
                'type' => 'number_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'short_description',
                'name' => 'Short description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'row_count' => 8,
            ],
            [
                'code' => 'description',
                'name' => 'Description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'field_type' => 'markdown_field',
            ],
            [
                'code' => 'meta_title',
                'name' => 'Meta Title',
                'type' => 'text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
            ],
            [
                'code' => 'meta_keywords',
                'name' => 'Meta Keywords',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
            ],
            [
                'code' => 'meta_description',
                'name' => 'Meta Description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
            ],
            [
                'code' => 'url_key',
                'name' => 'Url Key',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['entity_code'] = $this->catalogProductRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->catalogProductRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->catalogProductRepository->getEntityCode());
        $this->catalogProductRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
