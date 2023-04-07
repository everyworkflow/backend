<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Entity;

use EveryWorkflow\EavBundle\Entity\Entity;
use EveryWorkflow\EavBundle\Repository\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityBaseTest extends KernelTestCase
{
    public function testCanDoBasicEntityThing(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        /** @var EntityRepository $entityRepository */
        $entityRepository = $container->get(EntityRepository::class);

        $entity = $entityRepository->create();

        /* Checking most imp getters and setters working properly */
        $entity->setCode('user');
        $entity->setClass(Entity::class);
        $entity->setName('User Name');

        $this->assertEquals('user', $entity->getCode(), '$entity->getCode of simple attribute');

        /* Check if toArray working properly */
        $this->assertContains('user', $entity->toArray(), '$entity->toArray must have user as code');
        $this->assertContains('User Name', $entity->toArray(), '$entity->toArray must have User Name as name');

        /* Checking if serialize and unserialize works properly */
        $newData = serialize($entity);
        $entity = unserialize($newData);

        $this->assertEquals('user', $entity->getCode(), '$entity->getCode of simple attribute after unserialize');

        /* Check if toArray working properly after unserialize */
        $this->assertContains(
            'user',
            $entity->toArray(),
            '$entity->toArray must have user as code after unserialize'
        );
        $this->assertContains(
            'User Name',
            $entity->toArray(),
            '$entity->toArray must have User Name as name after unserialize'
        );
    }
}
