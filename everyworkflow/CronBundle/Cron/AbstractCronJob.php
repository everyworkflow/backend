<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Cron;

abstract class AbstractCronJob
{
    public function getCode(): string
    {
        return '';
    }
}
