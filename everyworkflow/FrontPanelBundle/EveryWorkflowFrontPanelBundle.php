<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\FrontPanelBundle;

use EveryWorkflow\FrontPanelBundle\DependencyInjection\FrontPanelExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowFrontPanelBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new FrontPanelExtension();
    }
}
