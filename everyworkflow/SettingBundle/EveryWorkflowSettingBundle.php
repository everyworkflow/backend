<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle;

use EveryWorkflow\SettingBundle\DependencyInjection\SettingExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowSettingBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SettingExtension();
    }
}
