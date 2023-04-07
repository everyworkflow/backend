<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MongoBundle\Model;

use EveryWorkflow\MongoBundle\Support\SyncInterface;

class SyncList implements SyncListInterface
{
    /**
     * All the sync types, injected via service.
     * @param $syncList SyncInterface[]
     */
    public function __construct(
        protected iterable $syncList = []
    ) {
    }

    /**
     * @return SyncInterface[]
     */
    public function getSortedList(): array
    {
        $sortedSyncNames = [];

        $syncList = [];
        foreach ($this->syncList as $obj) {
            if ($obj instanceof SyncInterface) {
                $class = get_class($obj);
                $classNameArr = explode('\\', $class);
                $fileName = $classNameArr[count($classNameArr) - 1];
                $sortedSyncNames[$fileName][] = $class;
                $syncList[$class] = $obj;
            }
        }

        ksort($sortedSyncNames);

        $sortedSyncList = [];
        foreach ($sortedSyncNames as $fileName => $classes) {
            foreach ($classes as $class) {
                $sortedSyncList[$class] = $syncList[$class];
            }
        }

        return $sortedSyncList;
    }

}
