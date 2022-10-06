<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;

interface DataCollectionFactoryInterface
{
    public function create(array $data = []): DataCollectionInterface;
}
