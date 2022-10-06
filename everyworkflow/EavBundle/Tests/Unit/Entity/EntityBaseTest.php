<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Entity;

use EveryWorkflow\CoreBundle\Model\DataObject;
use EveryWorkflow\CoreBundle\Tests\BaseTestCase;
use EveryWorkflow\EavBundle\Entity\Entity;

class EntityBaseTest extends BaseTestCase
{
    public function test_can_do_basic_entity_thing(): void
    {
        $dataObj = new DataObject();
        $entity = new Entity($dataObj);

        /* Checking most imp getters and setters working properly */
        $entity->setCode('user');
        $entity->setClass(Entity::class);
        $entity->setName('User Name');

        self::assertEquals('user', $entity->getCode(), '$entity->getCode of simple attribute');

        /* Check if toArray working properly */
        self::assertContains('user', $entity->toArray(), '$entity->toArray must have user as code');
        self::assertContains('User Name', $entity->toArray(), '$entity->toArray must have User Name as name');

        /* Checking if serialize and unserialize works properly */
        $newData = serialize($entity);
        $entity = unserialize($newData);

        self::assertEquals('user', $entity->getCode(), '$entity->getCode of simple attribute after unserialize');

        /* Check if toArray working properly after unserialize */
        self::assertContains(
            'user',
            $entity->toArray(),
            '$entity->toArray must have user as code after unserialize'
        );
        self::assertContains(
            'User Name',
            $entity->toArray(),
            '$entity->toArray must have User Name as name after unserialize'
        );
    }
}
