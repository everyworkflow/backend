<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Support;

interface ArrayableInterface
{
    /**
     * Export data to array.
     *
     * @return array<int,mixed>
     */
    public function toArray(): array;
}
