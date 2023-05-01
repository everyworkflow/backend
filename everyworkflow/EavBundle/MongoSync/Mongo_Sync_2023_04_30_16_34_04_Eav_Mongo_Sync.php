<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\MongoSync;

use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SyncInterface;

class Mongo_Sync_2023_04_30_16_34_04_Eav_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository
    ) {
    }

    public function sync(): bool
    {
        $this->entityRepository->getCollection()->createIndex(['status' => 1]);
        $this->entityRepository->getCollection()->createIndex(['code' => 1], ['unique' => true]);
        $this->entityRepository->getCollection()->createIndex(['updated_at' => 1]);

        $this->attributeRepository->getCollection()->createIndex(['status' => 1]);
        $this->attributeRepository->getCollection()->createIndex(['code' => 1, 'entity_code' => 1], ['unique' => true]);
        $this->attributeRepository->getCollection()->createIndex(['updated_at' => 1]);

        $this->attributeGroupRepository->getCollection()->createIndex(['status' => 1]);
        $this->attributeGroupRepository->getCollection()->createIndex(['entity_code' => 1]);
        $this->attributeGroupRepository->getCollection()->createIndex(['code' => 1], ['unique' => true]);
        $this->attributeGroupRepository->getCollection()->createIndex(['updated_at' => 1]);

        return self::SUCCESS;
    }
}
