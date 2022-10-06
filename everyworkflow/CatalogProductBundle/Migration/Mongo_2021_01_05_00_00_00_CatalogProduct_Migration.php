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
    protected EntityRepositoryInterface $entityRepository;
    protected AttributeRepositoryInterface $attributeRepository;
    protected CatalogProductRepositoryInterface $catalogProductRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        AttributeRepositoryInterface $attributeRepository,
        CatalogProductRepositoryInterface $catalogProductRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->attributeRepository = $attributeRepository;
        $this->catalogProductRepository = $catalogProductRepository;
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
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['entity_code'] = $this->catalogProductRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        $indexKeys = [];
        foreach ($this->catalogProductRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->catalogProductRepository->getCollection()
            ->createIndex($indexKeys, ['unique' => true]);

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
