<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\PageBuilderBundle\Component;

class LinkComponentFactory
{
    public function create(): LinkComponent
    {
        return new LinkComponent();
    }
}
