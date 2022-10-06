<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle;

use EveryWorkflow\CatalogProductBundle\DependencyInjection\CatalogProductExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCatalogProductBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CatalogProductExtension();
    }
}
