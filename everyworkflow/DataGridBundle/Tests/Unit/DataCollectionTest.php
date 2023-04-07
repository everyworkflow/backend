<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataGridBundle\Tests\Unit;

use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\DataGridBundle\Factory\DataCollectionFactory;

class DataCollectionTest extends AbstractDataGrid
{
    public function testDataCollection(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var DataObjectFactory $dataObjectFactory */
        $dataObjectFactory = $container->get(DataObjectFactory::class);
        /** @var DataCollectionFactory $collectionFactory */
        $collectionFactory = $container->get(DataCollectionFactory::class);
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

        $this->assertArrayHasKey('results', $collectionData, 'DataCollection must have >> results << array key.');
        $this->assertArrayHasKey('meta', $collectionData, 'DataCollection must have >> meta << array key.');
        $this->assertCount(count($results), $collectionData['results']);
        $this->assertEquals(count($results), $collectionData['meta']['per_page']);
    }
}
