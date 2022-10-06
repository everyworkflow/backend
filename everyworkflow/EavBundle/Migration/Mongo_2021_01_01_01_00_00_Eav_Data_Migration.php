<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Migration;

use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_01_01_00_00_Eav_Data_Migration implements MigrationInterface
{
    protected EntityRepositoryInterface $entityRepository;
    protected AttributeRepositoryInterface $attributeRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function migrate(): bool
    {
        $indexKeys = [];
        foreach ($this->entityRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->entityRepository->getCollection()->createIndex($indexKeys, ['unique' => true]);
        $indexKeys = [];
        foreach ($this->attributeRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->attributeRepository->getCollection()->createIndex($indexKeys, ['unique' => true]);
        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->entityRepository->getCollection()->drop();
        $this->attributeRepository->getCollection()->drop();
        return self::SUCCESS;
    }
}
