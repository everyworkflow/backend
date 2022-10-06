<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle;

use EveryWorkflow\SwaggerBundle\DependencyInjection\SwaggerExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowSwaggerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SwaggerExtension();
    }
}
