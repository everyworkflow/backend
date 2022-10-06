<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Migration;

use EveryWorkflow\MongoBundle\Support\MigrationInterface;
use EveryWorkflow\StaticBlockBundle\Repository\StaticBlockRepositoryInterface;

class Mongo_2021_01_03_03_00_00_Static_Block_Migration implements MigrationInterface
{
    protected StaticBlockRepositoryInterface $staticBlockRepository;

    public function __construct(StaticBlockRepositoryInterface $staticBlockRepository)
    {
        $this->staticBlockRepository = $staticBlockRepository;
    }

    public function migrate(): bool
    {
        $indexKeys = [];
        foreach ($this->staticBlockRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->staticBlockRepository->getCollection()->createIndex($indexKeys, ['unique' => true]);
        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->staticBlockRepository->getCollection()->drop();
        return self::SUCCESS;
    }
}
