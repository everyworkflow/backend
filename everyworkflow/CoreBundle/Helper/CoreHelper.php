<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Helper;

use EveryWorkflow\CoreBundle\Cache\CacheInterface;
use EveryWorkflow\CoreBundle\Message\MessageInterface;
use Psr\Log\LoggerInterface;

class CoreHelper implements CoreHelperInterface
{
    protected CacheInterface $cache;
    protected MessageInterface $message;
    protected LoggerInterface $logger;

    public function __construct(
        CacheInterface $cache,
        MessageInterface $message,
        LoggerInterface $logger
    ) {
        $this->cache = $cache;
        $this->message = $message;
        $this->logger = $logger;
    }

    /**
     * @return CacheInterface
     */
    public function getEWFCacheInterface(): CacheInterface
    {
        return $this->cache;
    }

    /**
     * @return MessageInterface
     */
    public function getMessageInterface(): MessageInterface
    {
        return $this->message;
    }

    public function getLoggerInterface(): LoggerInterface
    {
        return $this->logger;
    }
}
