<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\DependencyInjection;

use EveryWorkflow\CoreBundle\Model\CoreConfigProvider;
use EveryWorkflow\CoreBundle\Validation\Type\AbstractValidation;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class CoreExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $definition = $container->getDefinition(CoreConfigProvider::class);
        $definition->addArgument($mergedConfig);

        $container->registerForAutoconfiguration(AbstractValidation::class)
            ->setShared(false)->setPublic(true);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $ymlLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $ymlLoader->load('core.yaml');
    }
}
