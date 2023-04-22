<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\IndexerBundle\Support;

interface IndexerInterface
{
    public const SUCCESS = true;
    public const FAILURE = false;

    public function getCode(): string;

    public function getPriority(): int;

    /**
     * @return string[]
     */
    public function getDependencyCodes(): array;

    /**
     * Execute indexer invalid.
     */
    public function invalid(): bool;


    /**
     * Execute indexer index.
     */
    public function index(): bool;
}
