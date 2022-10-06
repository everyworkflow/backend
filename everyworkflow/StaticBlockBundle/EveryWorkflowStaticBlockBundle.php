<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle;

use EveryWorkflow\StaticBlockBundle\DependencyInjection\StaticBlockExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowStaticBlockBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new StaticBlockExtension();
    }
}
