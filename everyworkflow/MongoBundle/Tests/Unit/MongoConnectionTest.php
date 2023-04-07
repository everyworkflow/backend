<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\MongoBundle\Tests\Unit;

use EveryWorkflow\MongoBundle\Model\MongoConnection;
use EveryWorkflow\MongoBundle\Repository\BaseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MongoConnectionTest extends KernelTestCase
{
    public const COLLECTION_NAME = 'test_document_collection';

    protected function tearDown(): void
    {
        parent::tearDown();

        $container = self::getContainer();

        /** @var MongoConnection $mongoConnection */
        $mongoConnection = $container->get(MongoConnection::class);
        $userRepository = new BaseRepository($mongoConnection, self::COLLECTION_NAME);
        $userRepository->getCollection()->drop();
    }

    public function testMongodbTestConnection(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var MongoConnection $mongoConnection */
        $mongoConnection = $container->get(MongoConnection::class);
        $userRepository = new BaseRepository($mongoConnection, self::COLLECTION_NAME);

        $userData = [
            [
                'first_name' => 'Test 1',
                'last_name' => 'Name 1',
                'email' => 'test1@example.com',
                'gender' => 'male',
            ],
            [
                'first_name' => 'Test 2',
                'last_name' => 'Name 2',
                'email' => 'test2@example.com',
                'gender' => 'male',
            ],
        ];
        $userRepository->getCollection()->insertMany($userData);

        $this->assertCount($userRepository->getCollection()->countDocuments(), $userData, 'Stored document count must be same.');

        /** @var \MongoDB\Model\BSONDocument $dbUser1 */
        $dbUser1 = $userRepository->getCollection()->findOne(['email' => 'test1@example.com']);
        $dbUser1Data = $dbUser1->getArrayCopy();
        $this->assertArrayHasKey('_id', $dbUser1Data, 'Db user1 data must have >> _id << array key.');
        $this->assertArrayHasKey('first_name', $dbUser1Data, 'Db user1 data must have >> first_name << array key.');
        $this->assertArrayHasKey('last_name', $dbUser1Data, 'Db user1 data must have >> last_name << array key.');
        $this->assertArrayHasKey('email', $dbUser1Data, 'Db user1 data must have >> email << array key.');
        $this->assertEquals('test1@example.com', $dbUser1Data['email'], 'Db user1 email must be same.');
        $this->assertArrayHasKey('gender', $dbUser1Data, 'Db user1 data must have >> gender << array key.');

        /** @var \MongoDB\Model\BSONDocument $dbUser2 */
        $dbUser2 = $userRepository->getCollection()->findOne(['email' => 'test2@example.com']);
        $dbUser2Data = $dbUser2->getArrayCopy();
        $this->assertArrayHasKey('_id', $dbUser2Data, 'Db user2 data must have >> _id << array key.');
        $this->assertArrayHasKey('first_name', $dbUser2Data, 'Db user2 data must have >> first_name << array key.');
        $this->assertArrayHasKey('last_name', $dbUser2Data, 'Db user2 data must have >> last_name << array key.');
        $this->assertArrayHasKey('email', $dbUser2Data, 'Db user2 data must have >> email << array key.');
        $this->assertEquals('test2@example.com', $dbUser2Data['email'], 'Db user2 email must be same.');
        $this->assertArrayHasKey('gender', $dbUser2Data, 'Db user2 data must have >> gender << array key.');
    }
}
