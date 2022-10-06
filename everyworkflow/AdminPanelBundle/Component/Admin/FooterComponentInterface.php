<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Component\Admin;

interface FooterComponentInterface
{
    public function getData(): ?array;
}
