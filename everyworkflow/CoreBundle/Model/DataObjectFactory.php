<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class DataObjectFactory implements DataObjectFactoryInterface
{
    public function create(array $data = []): DataObjectInterface
    {
        return new DataObject($data);
    }

    public function createFromClassName(string $className, array $data = []): DataObjectInterface
    {
        return new $className($data);
    }

    public function createObjectFromClassName(string $className, array $data = []): mixed
    {
        return new $className($this->create($data));
    }
}
