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

class IndexerTest extends KernelTestCase
{
    public const TEST_INDEXER_CODE = 'test_index';

    public function testSimpleIndex(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var $IndexerRepository IndexerRepository * */
        $indexerRepostiory = $container->get(IndexerRepository::class);
        // $indexerList = new IndexerList($indexerRepostiory);

        $indexerRepostiory->deleteOneByFilter([
            'code' => self::TEST_INDEXER_CODE,
        ]);

        $eventDispatcherStub = $this->createStub(EventDispatcher::class);
        $eventDispatcherStub->method('dispatch');

        $indexerStub = $this->createStub(\EveryWorkflow\IndexerBundle\Support\IndexerInterface::class);
        $indexerStub->method('getCode')->willReturn(self::TEST_INDEXER_CODE);
        $indexerStub->method('execute')->willReturn(true);

        $indexerList = new IndexerList($indexerRepostiory, $eventDispatcherStub, [$indexerStub]);

        try {
            $indexer = $indexerRepostiory->findOne(['code' => self::TEST_INDEXER_CODE]);
        } catch (\Exception $e) {
            $indexer = null;
        }

        $this->assertNull($indexer, self::TEST_INDEXER_CODE . ' should not have been executed.');
    }
}
