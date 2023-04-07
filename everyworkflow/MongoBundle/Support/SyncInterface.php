<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Support;

interface SyncInterface
{
    public const SUCCESS = true;
    public const FAILURE = false;

    /**
     * This function will execute while sync.
     */
    public function sync(): bool;
}
