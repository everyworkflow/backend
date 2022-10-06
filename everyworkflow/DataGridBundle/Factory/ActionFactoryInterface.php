<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\DataGridBundle\Model\ActionInterface;

interface ActionFactoryInterface
{
    public function create(string $className, array $data = []): ActionInterface;
}
