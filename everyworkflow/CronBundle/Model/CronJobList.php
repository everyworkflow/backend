<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Model;

use Cron\CronExpression;
use EveryWorkflow\CronBundle\Repository\CronJobRepositoryInterface;
use EveryWorkflow\CronBundle\Support\CronJobInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Process\Process;

class CronJobList implements CronJobListInterface
{
    protected array $processList = [];

    /**
     * All the cron jobs, injected via service.
     *
     * @var CronJobInterface[]
     */
    protected iterable $cronJobs;

    public function __construct(
        protected CronJobRepositoryInterface $cronJobRepository,
        protected EventDispatcherInterface $eventDispatcher,
        iterable $cronJobs = []
    ) {
        $this->cronJobs = $cronJobs;
    }

    public function execute(array $jobCodes = [], $isForced = false): void
    {
        $jobCodeCount = count($jobCodes);
        foreach ($this->cronJobs as $job) {
            if (0 === $jobCodeCount) {
                $this->runSingleJob($job, $isForced);
            } else {
                $jobCode = $this->getJobCode($job);
                if (in_array($jobCode, $jobCodes, true)) {
                    $this->runSingleJob($job, $isForced, true);
                }
            }
        }

        $this->manageRunningProcess();
    }

    protected function getJobCode(CronJobInterface $item): string
    {
        $code = $item->getCode() ?? '';
        if ('' === $code) {
            $className = get_class($item);
            $code = str_replace('\\', '_', $className);
        }

        return $code;
    }

    protected function runSingleJob(CronJobInterface $job, $isForced = false, $canExecute = false): void
    {
        $schedule = $job->getSchedule();
        $jobCode = $this->getJobCode($job);

        try {
            $cronJob = $this->cronJobRepository->findOne(['code' => $jobCode]);
        } catch (\Exception $e) {
            $cronJob = $this->cronJobRepository->create([
                'code' => $jobCode,
                'status' => 'enable',
                'class_name' => get_class($job),
                'schedule_at' => null,
            ]);
        }

        if ('enable' !== $cronJob->getData('status')) {
            return;
        }

        $cron = CronExpression::factory($schedule);
        $cronJob->setData('schedule', $schedule);
        if (!$isForced && !$cron->isDue()) {
            echo PHP_EOL.'- not due: '.$jobCode.' at '.date('Y-m-d H:i:s');

            return;
        }

        if (!$isForced && in_array($cronJob->getData('state'), ['processing'], true)) {
            return;
        }

        if ($canExecute) {
            $cronJob->setData('state', 'processing');
            $cronJob->setData('error_message', '');
            $cronJob = $this->cronJobRepository->saveOne($cronJob);
            echo PHP_EOL.'- Running: '.$jobCode.' at '.date('Y-m-d H:i:s');

            try {
                $this->eventDispatcher->dispatch(
                    $cronJob,
                    'cron_job_'.$jobCode.'_execute_before'
                );
                $result = $job->execute();
                if ($result) {
                    echo PHP_EOL.'- Completed: '.$jobCode.' at '.date('Y-m-d H:i:s');
                    $cronJob->setData('state', 'completed');
                } else {
                    echo PHP_EOL.'- Failed: '.$jobCode.' at '.date('Y-m-d H:i:s');
                    $cronJob->setData('state', 'failed');
                }
                $cronJob->setData('error_message', '');
                $this->eventDispatcher->dispatch(
                    $cronJob,
                    'cron_job_'.$jobCode.'_execute_after'
                );
            } catch (\Exception $e) {
                echo PHP_EOL.'Error: '.$jobCode.' at '.date('Y-m-d H:i:s').' Message: '.$e->getMessage();
                $cronJob->setData('state', 'error');
                $cronJob->setData('error_message', $e->getMessage());
            }

            $cronJob->setData('schedule_at', $cron->getNextRunDate()->format('Y-m-d H:i:s'));
        } else {
            $cronJob->setData('state', 'starting');
            $cronJob->setData('error_message', '');

            $commandArray = ['bin/console', 'cron:run', '-j', $jobCode];
            if ($isForced) {
                $commandArray[] = '-f';
            }
            $process = new Process($commandArray);
            $process->start();

            $cronJob->setData('process_id', $process->getPid());

            $this->processList[$jobCode] = $process;
        }

        $cronJob = $this->cronJobRepository->saveOne($cronJob);
    }

    protected function manageRunningProcess(): void
    {
        foreach ($this->processList as $jobCode => $process) {
            $process->wait();
            $cronJob = $this->cronJobRepository->findOne(['code' => $jobCode]);
            $logMsg = PHP_EOL.'--- Cron: '.$jobCode.' | schedule: '.$cronJob->getData('schedule').' | schedule_at: '.$cronJob->getData('schedule_at');
            $logMsg = PHP_EOL;
            $logMsg .= (string) $process->getOutput();
            $cronJob->setData('log', $logMsg);
            $cronJob->setData('process_id', null);
            echo $logMsg;
            $this->cronJobRepository->saveOne($cronJob);
        }
    }
}
