<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;

interface EntityFactoryInterface
{
    /**
     * @param string $className
     * @param array $data
     * @return BaseEntityInterface
     */
    public function create(string $className, array $data = []): BaseEntityInterface;
}
