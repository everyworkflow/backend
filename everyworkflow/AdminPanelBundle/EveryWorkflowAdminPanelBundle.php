<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle;

use EveryWorkflow\AdminPanelBundle\DependencyInjection\AdminPanelExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowAdminPanelBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new AdminPanelExtension();
    }
}
