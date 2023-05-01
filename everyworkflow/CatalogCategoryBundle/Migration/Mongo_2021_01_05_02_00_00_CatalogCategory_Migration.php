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
        /** @var EntityDocument $entity */
        $entity = $this->entityRepository->create();
        $entity
            ->setName('Catalog category')
            ->setCode($this->catalogCategoryRepository->getEntityCode())
            ->setClass(CatalogCategoryEntity::class)
            ->setStatus(CatalogCategoryEntity::STATUS_ENABLE);
        $entity->setData('flags', ['can_delete' => false, 'can_update' => false]);
        $this->entityRepository->saveOne($entity);

        $attributeData = [
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
                'code' => 'code',
                'name' => 'Code',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 15,
                'flags' => ['can_delete' => false, 'can_update' => false],
            ],
            [
                'code' => 'path',
                'name' => 'Path',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 20,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'parent',
                'name' => 'Parent',
                'type' => 'select_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 25,
                'flags' => ['can_delete' => false],
            ],
        ];

        foreach ($attributeData as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->catalogCategoryRepository->getEntityCode();
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

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
