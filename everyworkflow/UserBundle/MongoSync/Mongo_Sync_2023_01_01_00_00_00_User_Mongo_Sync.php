<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\MongoSync;

use EveryWorkflow\MongoBundle\Support\SyncInterface;
use EveryWorkflow\UserBundle\Repository\UserRepositoryInterface;

class Mongo_Sync_2023_01_01_00_00_00_User_Mongo_Sync implements SyncInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    public function sync(): bool
    {
        $this->userRepository->getCollection()->createIndex(['status' => 1]);
        // $this->userRepository->getCollection()->createIndex(['username' => 1], ['unique' => true]);
        $this->userRepository->getCollection()->createIndex(['email' => 1], ['unique' => true]);
        // $this->userRepository->getCollection()->createIndex(['phone' => 1], ['unique' => true]);
        $this->userRepository->getCollection()->createIndex(['updated_at' => 1]);
        return self::SUCCESS;
    }
}
