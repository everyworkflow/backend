<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Migration;

use EveryWorkflow\CatalogCategoryBundle\Entity\CatalogCategoryEntity;
use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_05_02_00_00_CatalogCategory_Migration implements MigrationInterface
{
    protected EntityRepositoryInterface $entityRepository;
    protected AttributeRepositoryInterface $attributeRepository;
    protected CatalogCategoryRepositoryInterface $catalogCategoryRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        AttributeRepositoryInterface $attributeRepository,
        CatalogCategoryRepositoryInterface $catalogCategoryRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->attributeRepository = $attributeRepository;
        $this->catalogCategoryRepository = $catalogCategoryRepository;
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $categoryEntity */
        $categoryEntity = $this->entityRepository->create();
        $categoryEntity
            ->setName('Catalog category')
            ->setCode($this->catalogCategoryRepository->getEntityCode())
            ->setClass(CatalogCategoryEntity::class)
            ->setStatus(CatalogCategoryEntity::STATUS_ENABLE);
        $this->entityRepository->saveOne($categoryEntity);

        $attributeData = [
            [
                'code' => 'name',
                'name' => 'Name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'path',
                'name' => 'Path',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['entity_code'] = $this->catalogCategoryRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        $indexKeys = [];
        foreach ($this->catalogCategoryRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->catalogCategoryRepository->getCollection()
            ->createIndex($indexKeys, ['unique' => true]);

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository
            ->deleteByFilter(['entity_code' => $this->catalogCategoryRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->catalogCategoryRepository->getEntityCode());
        $this->catalogCategoryRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
