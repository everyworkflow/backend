<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Component\Admin;

class FooterComponent implements FooterComponentInterface
{
    public function getData(): ?array
    {
        $data = ['message' => 'This is just a testing for the vim codes :D'];
        return $data;
    }
}
