<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CmsBundle;

use EveryWorkflow\CmsBundle\DependencyInjection\CmsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCmsBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CmsExtension();
    }
}
