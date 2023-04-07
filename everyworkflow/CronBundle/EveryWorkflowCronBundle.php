<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle;

use EveryWorkflow\CronBundle\DependencyInjection\CronExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCronBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CronExtension();
    }
}
