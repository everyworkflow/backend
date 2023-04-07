<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\CronBundle\Support;

interface CronJobInterface
{
    public const SUCCESS = true;
    public const FAILURE = false;


    public function getCode(): string;

    public function getSchedule(): string;

    /**
     * Execute cron job.
     */
    public function execute(): bool;
}
