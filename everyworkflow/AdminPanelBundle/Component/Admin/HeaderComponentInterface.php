<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Component\Admin;

interface HeaderComponentInterface
{
    public function getData(): ?array;
}
