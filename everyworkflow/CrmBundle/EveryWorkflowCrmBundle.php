<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CrmBundle;

use EveryWorkflow\CrmBundle\DependencyInjection\CrmExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCrmBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CrmExtension();
    }
}
