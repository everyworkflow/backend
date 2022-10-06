<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataGridBundle\Tests\Unit;

use EveryWorkflow\DataGridBundle\Factory\DataCollectionFactory;
use EveryWorkflow\DataGridBundle\Tests\BaseGridTestCase;

class DataCollectionTest extends BaseGridTestCase
{
    public function test_data_collection(): void
    {
        $dataObjectFactory = $this->getDataObjectFactory();
        $collectionFactory = new DataCollectionFactory($dataObjectFactory);
        $collection = $collectionFactory->create();

        $results = [
            $dataObjectFactory->create([
                'id' => 1,
                'name' => 'Examples Name 1',
                'gender' => 'male',
            ]),
            $dataObjectFactory->create([
                'id' => 2,
                'name' => 'Examples Name 2',
                'gender' => 'female',
            ]),
            $dataObjectFactory->create([
                'id' => 3,
                'name' => 'Examples Name 3',
                'gender' => 'other',
            ]),
            $dataObjectFactory->create([
                'id' => 4,
                'name' => 'Examples Name 4',
                'gender' => 'male',
            ]),
        ];

        $collection->setFrom(1)
            ->setTo(count($results))
            ->setCurrentPage(1)
            ->setLastPage(2)
            ->setTotalCount(count($results) * 2)
            ->setPerPage(count($results))
            ->setResults($results);

        $collectionData = $collection->toArray();

        self::assertArrayHasKey('results', $collectionData, 'DataCollection must have >> results << array key.');
        self::assertArrayHasKey('meta', $collectionData, 'DataCollection must have >> meta << array key.');
        self::assertCount(count($results), $collectionData['results']);
        self::assertEquals(count($results), $collectionData['meta']['per_page']);
    }
}
