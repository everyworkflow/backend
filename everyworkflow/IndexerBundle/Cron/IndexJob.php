<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Cron;

use EveryWorkflow\CronBundle\Cron\AbstractCronJob;
use EveryWorkflow\IndexerBundle\Model\IndexerListInterface;

class IndexJob extends AbstractCronJob implements IndexJobInterface
{
    public function __construct(
        protected IndexerListInterface $indexerList
    ) {
    }

    public function getCode(): string
    {
        return 'index';
    }

    public function getSchedule(): string
    {
        return '*/1 * * * *';
    }

    public function execute(): bool
    {
        $this->indexerList->index();

        return self::SUCCESS;
    }
}
