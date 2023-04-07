<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\IndexerBundle;

use EveryWorkflow\IndexerBundle\DependencyInjection\IndexerExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowIndexerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new IndexerExtension();
    }
}
