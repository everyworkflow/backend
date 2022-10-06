<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Helper;

use EveryWorkflow\CoreBundle\Cache\CacheInterface;
use EveryWorkflow\CoreBundle\Message\MessageInterface;
use Psr\Log\LoggerInterface;

interface CoreHelperInterface
{
    public function getEWFCacheInterface(): CacheInterface;
    public function getMessageInterface(): MessageInterface;
    public function getLoggerInterface(): LoggerInterface;
}
