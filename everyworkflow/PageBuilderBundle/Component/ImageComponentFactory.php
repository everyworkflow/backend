<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component;

class ImageComponentFactory
{
    public function create(): ImageComponent
    {
        return new ImageComponent();
    }
}
