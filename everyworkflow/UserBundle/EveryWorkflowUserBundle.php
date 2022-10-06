<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle;

use EveryWorkflow\UserBundle\DependencyInjection\UserExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowUserBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new UserExtension();
    }
}
