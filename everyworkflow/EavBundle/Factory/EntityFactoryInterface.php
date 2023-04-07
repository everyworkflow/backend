<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;

interface EntityFactoryInterface
{
    public function create(string $className, array $data = []): BaseEntityInterface;
}
