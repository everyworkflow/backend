<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle;

use EveryWorkflow\CatalogSearchBundle\DependencyInjection\CatalogSearchExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCatalogSearchBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CatalogSearchExtension();
    }
}
