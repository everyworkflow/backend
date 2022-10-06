<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

interface DataObjectFactoryInterface
{
    public function create(array $data = []): DataObjectInterface;

    public function createFromClassName(string $className, array $data = []): DataObjectInterface;

    public function createObjectFromClassName(string $className, array $data = []): mixed;
}
