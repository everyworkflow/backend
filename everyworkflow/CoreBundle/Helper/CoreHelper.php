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
    public function __construct(
        protected CacheInterface $cache,
        protected MessageInterface $message,
        protected LoggerInterface $logger
    ) {
    }

    public function getEWFCacheInterface(): CacheInterface
    {
        return $this->cache;
    }

    public function getMessageInterface(): MessageInterface
    {
        return $this->message;
    }

    public function getLoggerInterface(): LoggerInterface
    {
        return $this->logger;
    }
}
