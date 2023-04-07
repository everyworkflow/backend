<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Tests\Unit;

use EveryWorkflow\CronBundle\Model\CronJobList;
use EveryWorkflow\CronBundle\Repository\CronJobRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MultiCronTest extends KernelTestCase
{
    public const TEST_CRON_JOB_CODE = 'multi_test_cron_job';

    protected function tearDown(): void
    {
        parent::tearDown();
        $container = self::getContainer();
        /* @var CronJobRepository $cronJobRepository */
        $cronJobRepository = $container->get(CronJobRepository::class);
        $cronJobRepository->deleteOneByFilter([
            'code' => self::TEST_CRON_JOB_CODE,
        ]);
    }

    public function testMutliCron(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        /** @var CronJobRepository $cronJobRepository */
        $cronJobRepository = $container->get(CronJobRepository::class);

        $cronJobRepository->deleteOneByFilter([
            'code' => self::TEST_CRON_JOB_CODE,
        ]);

        $eventDispatcherStub = $this->createStub(EventDispatcher::class);
        $eventDispatcherStub->method('dispatch');

        $cronJobStub = $this->createStub(\EveryWorkflow\CronBundle\Support\CronJobInterface::class);
        $cronJobStub->method('getCode')->willReturn(self::TEST_CRON_JOB_CODE);
        $cronJobStub->method('getSchedule')->willReturn('* * * * *');
        $cronJobStub->method('execute')->willReturn(true);

        $cronJobList = new CronJobList($cronJobRepository, $eventDispatcherStub, [$cronJobStub]);

        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertNull($cronJob, self::TEST_CRON_JOB_CODE . ' should not have been executed.');

        // Lets execute cron
        $cronJobList->execute([self::TEST_CRON_JOB_CODE]);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertEquals('completed', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . ' should have been executed.');

        $cronJob->setData('state', 'processing');
        $cronJobRepository->updateOne($cronJob);

        // Lets execute cron as job is processing
        $cronJobList->execute([self::TEST_CRON_JOB_CODE]);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertEquals('processing', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . ' should have been skipped.');

        // Lets execute cron with force and compelte job
        $cronJobList->execute([self::TEST_CRON_JOB_CODE], true);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }
        $this->assertEquals('completed', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . ' should have been executed.');
    }
}
