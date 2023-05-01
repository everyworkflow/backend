<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Migration;

use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;
use EveryWorkflow\SalesOrderBundle\Entity\SalesOrderEntity;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;

class Mongo_2021_01_10_00_00_00_SalesOrder_Migration implements MigrationInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected SalesOrderRepositoryInterface $salesOrderRepository
    ) {
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $entity */
        $entity = $this->entityRepository->create();
        $entity
            ->setName('Sales order')
            ->setCode($this->salesOrderRepository->getEntityCode())
            ->setClass(SalesOrderEntity::class)
            ->setStatus(SalesOrderEntity::STATUS_ENABLE);
        $entity->setData('flags', ['can_delete' => false, 'can_update' => false]);
        $this->entityRepository->saveOne($entity);

        $attributeData = [
            [
                'code' => 'email',
                'name' => 'Email',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'first_name',
                'name' => 'First name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'last_name',
                'name' => 'Last name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'customer_id',
                'name' => 'Customer ID',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->salesOrderRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->salesOrderRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->salesOrderRepository->getEntityCode());
        $this->salesOrderRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
