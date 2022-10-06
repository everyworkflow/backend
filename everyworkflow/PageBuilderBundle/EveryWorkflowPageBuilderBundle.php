<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle;

use EveryWorkflow\PageBuilderBundle\DependencyInjection\PageBuilderExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowPageBuilderBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new PageBuilderExtension();
    }
}
