<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Tests\Unit\Model;

use EveryWorkflow\CoreBundle\Model\DataObject;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\CoreBundle\Tests\BaseTestCase;

class DataObjectBaseTest extends BaseTestCase
{
    public function test_can_do_basic_things(): void
    {
        $dataObj = new DataObject();

        /* I must be able to set any value to data object */
        $dataObj->setData('name', 'John Doe');
        $dataObj->setData('email', 'john@doe.com');

        /* I must be able to get previous value with key */
        self::assertEquals('John Doe', $dataObj->getData('name'), 'get name');

        /* Has toArray function, that helps */
        self::assertInstanceOf(DataObjectInterface::class, $dataObj, 'object must be instance of DataObjectInterface');

        /* toArray must vomit data from object for all kinds of usage */
        self::assertContains('john@doe.com', $dataObj->toArray(), 'object->array must have email');

        /* Invalid key fetch must return null as default fallback */
        self::assertNull($dataObj->getData('invalid-data-key'), 'invalid data key returns null');

        /* Checking if serialize and unserialize works properly */
        $newData = serialize($dataObj);
        $dataObj = unserialize($newData);

        self::assertEquals('John Doe', $dataObj->getData('name'), 'get name after unserialize');
        self::assertEquals('john@doe.com', $dataObj->getData('email'), 'get email after unserialize');
    }

    public function test_can_construct_and_diconstruct_data_object(): void
    {
        /* Preparing data to revive DataObject */
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
        ];

        /* Creating John Doe DataObject */
        $dataObj = new DataObject($data);

        /* Checking if basic thing working */
        self::assertEquals('John Doe', $dataObj->getData('name'), 'get name');
        self::assertContains('john@doe.com', $dataObj->toArray(), 'object->toArray must have email');

        /* Creating second DataObject from first */
        $dataObj2 = new DataObject($dataObj->toArray());

        /* Checking if basic things working */
        self::assertEquals('John Doe', $dataObj2->getData('name'), 'get name 2');
        self::assertContains('john@doe.com', $dataObj2->toArray(), 'object->toArray must have email 2');
    }
}
