<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Indexer;

use EveryWorkflow\IndexerBundle\Support\IndexerInterface;

abstract class AbstractIndexer implements IndexerInterface
{
    protected bool $isForced = false;

    public function getCode(): string
    {
        return '';
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function isForced(): bool
    {
        return $this->isForced;
    }

    public function setIsForced(bool $isForced): self
    {
        $this->isForced = $isForced;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getDependencyCodes(): array
    {
        return [];
    }
}
