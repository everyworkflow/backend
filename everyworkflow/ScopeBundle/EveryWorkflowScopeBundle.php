<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\ScopeBundle;

use EveryWorkflow\ScopeBundle\DependencyInjection\ScopeExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowScopeBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ScopeExtension();
    }
}
