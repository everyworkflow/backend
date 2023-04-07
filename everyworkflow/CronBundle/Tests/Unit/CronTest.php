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

class CronTest extends KernelTestCase
{
    public const TEST_CRON_JOB_CODE = 'test_cron_job';

    protected function tearDown(): void
    {
        parent::tearDown();
        $container = self::getContainer();
        /** @var CronJobRepository $cronJobRepository */
        $cronJobRepository = $container->get(CronJobRepository::class);
        $cronJobRepository->deleteByFilter([
            'code' => [
                '$in' => [
                    self::TEST_CRON_JOB_CODE,
                    self::TEST_CRON_JOB_CODE . '2',
                ],
            ],
        ]);
    }

    public function testSimpleCronJob(): void
    {
        self::bootKernel();

        $container = self::getContainer();
        /** @var CronJobRepository $cronJobRepository */
        $cronJobRepository = $container->get(CronJobRepository::class);

        $cronJobRepository->deleteByFilter([
            'code' => [
                '$in' => [
                    self::TEST_CRON_JOB_CODE,
                    self::TEST_CRON_JOB_CODE . '2',
                ],
            ],
        ]);

        try {
            $cronJob = $cronJobRepository->findOne([
                'code' => [
                    self::TEST_CRON_JOB_CODE,
                ],
            ]);
        } catch (\Exception $e) {
            $cronJob = null;
        }
        $this->assertNull($cronJob, self::TEST_CRON_JOB_CODE . ' should have been deleted if existed.');

        $eventDispatcherStub = $this->createStub(EventDispatcher::class);
        $eventDispatcherStub->method('dispatch');

        $cronJobStub = $this->createStub(\EveryWorkflow\CronBundle\Support\CronJobInterface::class);
        $cronJobStub->method('getCode')->willReturn(self::TEST_CRON_JOB_CODE);
        $cronJobStub->method('getSchedule')->willReturn('* * * * *');
        $cronJobStub->method('execute')->willReturn(true);

        $cronJobStub2 = $this->createStub(\EveryWorkflow\CronBundle\Support\CronJobInterface::class);
        $cronJobStub2->method('getCode')->willReturn(self::TEST_CRON_JOB_CODE . '2');
        $cronJobStub2->method('getSchedule')->willReturn('* * * * *');
        $cronJobStub2->method('execute')->willReturn(false);

        $cronJobList = new CronJobList($cronJobRepository, $eventDispatcherStub, [$cronJobStub, $cronJobStub2]);

        // Execute without code will trigger console command
        // Lets execute cron with cron code
        $cronJobList->execute([self::TEST_CRON_JOB_CODE]);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertEquals('completed', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . ' state should have been completed.');

        // Lets execute cron job with force
        $cronJobList->execute([self::TEST_CRON_JOB_CODE], true);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE]);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertEquals('completed', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . ' state should have been completed with force.');

        // Lets execute failed cron job with force
        $cronJobList->execute([self::TEST_CRON_JOB_CODE . '2'], true);
        echo PHP_EOL;
        try {
            $cronJob = $cronJobRepository->findOne(['code' => self::TEST_CRON_JOB_CODE . '2']);
        } catch (\Exception $e) {
            $cronJob = null;
        }

        $this->assertNotNull($cronJob, self::TEST_CRON_JOB_CODE . '2 should have been inserted into database.');

        $this->assertEquals('failed', $cronJob?->getData('state'), self::TEST_CRON_JOB_CODE . '2 state should have been failed with force.');
    }
}
