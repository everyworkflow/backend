<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Indexer;

abstract class AbstractIndexer
{
    public function getCode(): string
    {
        return '';
    }

    public function getPriority(): int
    {
        return 0;
    }

    /**
     * @return string[]
     */
    public function getDependencyCodes(): array
    {
        return [];
    }
}
