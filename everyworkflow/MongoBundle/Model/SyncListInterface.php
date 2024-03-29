<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Model;

interface SyncListInterface
{
    /**
     * @return SyncInterface[]
     */
    public function getSortedList(): array;
}
