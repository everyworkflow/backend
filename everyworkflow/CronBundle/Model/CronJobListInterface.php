<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Model;

interface CronJobListInterface
{
    public function execute(array $jobCodes = [], $isForced = false): void;
}
