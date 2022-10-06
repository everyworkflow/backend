<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle;

use EveryWorkflow\UrlRewriteBundle\DependencyInjection\UrlRewriteExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowUrlRewriteBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new UrlRewriteExtension();
    }
}
