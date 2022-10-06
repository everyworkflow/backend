<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class EWFCache implements CacheInterface
{
    protected CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }

    public function getCachePool(): CacheItemPoolInterface
    {
        return $this->cacheItemPool;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getItem(string $cacheKey): CacheItemInterface
    {
        return $this->cacheItemPool->getItem($this->prepareKey($cacheKey));
    }

    public function prepareKey(string $key): string
    {
        return sha1($key);
    }

    public function save(CacheItemInterface $item): bool
    {
        return $this->cacheItemPool->save($item);
    }
}
