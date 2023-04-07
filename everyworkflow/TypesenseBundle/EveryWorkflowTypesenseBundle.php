<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\TypesenseBundle;

use EveryWorkflow\TypesenseBundle\DependencyInjection\TypesenseExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowTypesenseBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new TypesenseExtension();
    }
}
