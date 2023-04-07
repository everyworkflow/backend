<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Model;

interface IndexerListInterface
{
    public function invalid(array $indexCodes = [], $isForced = true): void;

    public function reindex(array $indexCodes = [], $isForced = true): void;

    public function index(array $indexCodes = [], $isForced = true): void;
}
