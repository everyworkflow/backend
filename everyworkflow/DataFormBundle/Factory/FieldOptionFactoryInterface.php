<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

interface FieldOptionFactoryInterface
{
    public function create(string $className, array $data): mixed;
}
