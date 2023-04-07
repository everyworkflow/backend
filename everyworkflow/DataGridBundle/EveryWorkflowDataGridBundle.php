<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle;

use EveryWorkflow\DataGridBundle\DependencyInjection\DataGridExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowDataGridBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DataGridExtension();
    }
}
