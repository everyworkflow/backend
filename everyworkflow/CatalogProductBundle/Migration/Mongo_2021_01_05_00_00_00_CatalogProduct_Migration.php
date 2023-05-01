<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Migration;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntity;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_05_00_00_00_CatalogProduct_Migration implements MigrationInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $entity */
        $entity = $this->entityRepository->create();
        $entity
            ->setName('Catalog product')
            ->setCode($this->catalogProductRepository->getEntityCode())
            ->setClass(CatalogProductEntity::class)
            ->setStatus(CatalogProductEntity::STATUS_ENABLE);
        $entity->setData('flags', ['can_delete' => false, 'can_update' => false]);
        $this->entityRepository->saveOne($entity);

        $attributeData = [
            [
                'code' => 'sku',
                'name' => 'Sku',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 5,
                'flags' => ['can_delete' => false, 'can_update' => false],
            ],
            [
                'code' => 'name',
                'name' => 'Name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 10,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'price',
                'name' => 'Price',
                'type' => 'currency_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 50,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'special_price_from',
                'name' => 'Special Price From',
                'type' => 'date_time_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 51,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'special_price',
                'name' => 'Special Price',
                'type' => 'currency_attribute',
                'sort_order' => 52,
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'special_price_to',
                'name' => 'Special Price To',
                'type' => 'date_time_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 53,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'quantity',
                'name' => 'Quantity',
                'type' => 'number_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 80,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'short_description',
                'name' => 'Short description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'row_count' => 8,
                'sort_order' => 500,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'description',
                'name' => 'Description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'field_type' => 'markdown_field',
                'sort_order' => 1000,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'meta_title',
                'name' => 'Meta Title',
                'type' => 'text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'sort_order' => 9000,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'meta_keywords',
                'name' => 'Meta Keywords',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 9101,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'meta_description',
                'name' => 'Meta Description',
                'type' => 'long_text_attribute',
                'is_used_in_grid' => false,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 9102,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'url_key',
                'name' => 'Url Key',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 9103,
                'flags' => ['can_delete' => false],
            ],
        ];

        foreach ($attributeData as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->catalogProductRepository->getEntityCode();
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
