<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

interface CacheInterface
{
    public function getCachePool(): CacheItemPoolInterface;

    /**
     * @throws InvalidArgumentException
     */
    public function getItem(string $cacheKey): CacheItemInterface;

    public function prepareKey(string $key): string;

    public function save(CacheItemInterface $item): bool;
}
