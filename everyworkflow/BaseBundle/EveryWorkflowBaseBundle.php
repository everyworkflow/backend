<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\BaseBundle;

use EveryWorkflow\BaseBundle\DependencyInjection\BaseExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowBaseBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new BaseExtension();
    }
}
