<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle\Tests\Unit;

use EveryWorkflow\IndexerBundle\Model\IndexerList;
use EveryWorkflow\IndexerBundle\Repository\IndexerRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MultiIndexerTest extends KernelTestCase
{
    public const TEST_INDEXER_CODE = 'multi_test_index';

    public function testMultiIndex(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var IndexerRepository $indexerRepository **/
        $indexerRepository = $container->get(IndexerRepository::class);

        $indexerRepository->deleteByFilter([
            'code' => self::TEST_INDEXER_CODE,
        ]);

        $eventDispatcherStub = $this->createStub(EventDispatcher::class);
        $eventDispatcherStub->method('dispatch');

        $indexerStub = $this->createStub(\EveryWorkflow\IndexerBundle\Support\IndexerInterface::class);
        $indexerStub->method('getCode')->willReturn(self::TEST_INDEXER_CODE);
        $indexerStub->method('index')->willReturn(true);

        $indexerList = new IndexerList($indexerRepository, $eventDispatcherStub, [$indexerStub]);

        try {
            $indexer = $indexerRepository->findOne(['code' => self::TEST_INDEXER_CODE]);
        } catch (\Exception $e) {
            $indexer = null;
        }

        $this->assertNull($indexer, self::TEST_INDEXER_CODE . ' should not have been executed.');

        // Execute without code will trigger console command
        // Lets execute index with cron code
        echo PHP_EOL;
        $indexerList->index([self::TEST_INDEXER_CODE]);

        try {
            $indexer = $indexerRepository->findOne(['code' => self::TEST_INDEXER_CODE]);
        } catch (\Exception $e) {
            $indexer = null;
        }

        $this->assertEquals('completed', $indexer?->getData('state'), self::TEST_INDEXER_CODE . ' state should have been completed.');

        // Lets set state is processing
        $indexer->setData('state', 'processing');
        $indexerRepository->updateOne($indexer);

        // Lets execute index with cron code
        $indexerList->index([self::TEST_INDEXER_CODE]);

        try {
            $indexer = $indexerRepository->findOne(['code' => self::TEST_INDEXER_CODE]);
        } catch (\Exception $e) {
            $indexer = null;
        }

        $this->assertEquals('processing', $indexer?->getData('state'), self::TEST_INDEXER_CODE . ' should have been skipped as it is processing.');

        // Lets execute index with force and complete index
        $indexerList->index([self::TEST_INDEXER_CODE], true);

        try {
            $indexer = $indexerRepository->findOne(['code' => self::TEST_INDEXER_CODE]);
        } catch (\Exception $e) {
            $indexer = null;
        }

        $this->assertEquals('completed', $indexer?->getData('state'), self::TEST_INDEXER_CODE . ' should have been completed.');
    }
}
