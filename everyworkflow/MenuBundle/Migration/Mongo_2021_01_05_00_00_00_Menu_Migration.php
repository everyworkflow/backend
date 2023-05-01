<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MenuBundle\Migration;

use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MenuBundle\Entity\MenuEnity;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_05_00_00_00_Menu_Migration implements MigrationInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected MenuRepositoryInterface $menuRepository
    ) {
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $entity */
        $entity = $this->entityRepository->create();
        $entity
            ->setName('Menu')
            ->setCode($this->menuRepository->getEntityCode())
            ->setClass(MenuEnity::class)
            ->setStatus(MenuEnity::STATUS_ENABLE);
        $entity->setData('flags', ['can_delete' => false, 'can_update' => false]);
        $this->entityRepository->saveOne($entity);

        $attributeData = [
            [
                'code' => 'code',
                'name' => 'Code',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'name',
                'name' => 'Name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'flags' => ['can_delete' => false],
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->menuRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->menuRepository->getEntityCode()]);
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->menuRepository->getEntityCode()]);
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->menuRepository->getEntityCode()]);
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->menuRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->menuRepository->getEntityCode());
        $this->menuRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
