<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Component\BaseComponentInterface;

interface ComponentFactoryInterface
{
    public function create(string $className, array $data = []): BaseComponentInterface;
}
