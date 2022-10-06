<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Component\Admin;

class HeaderComponent implements HeaderComponentInterface
{
    public function getData(): ?array
    {
        $data = ['message' => 'header'];
        return $data;
    }
}
