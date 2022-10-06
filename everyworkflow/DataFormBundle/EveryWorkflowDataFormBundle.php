<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle;

use EveryWorkflow\DataFormBundle\DependencyInjection\DataFormExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowDataFormBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DataFormExtension();
    }
}
