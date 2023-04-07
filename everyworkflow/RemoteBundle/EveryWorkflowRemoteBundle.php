<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle;

use EveryWorkflow\RemoteBundle\DependencyInjection\RemoteExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowRemoteBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new RemoteExtension();
    }
}
