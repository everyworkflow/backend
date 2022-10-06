<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\DependencyInjection;

use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapperInterface;
use EveryWorkflow\EavBundle\Attribute\Type\Select\OptionInterface;
use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;
use EveryWorkflow\EavBundle\Model\EavConfigProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class EavExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $definition = $container->getDefinition(EavConfigProvider::class);
        $definition->addArgument($mergedConfig);

        $container->registerForAutoconfiguration(BaseEntityInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(BaseAttributeInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(OptionInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(BaseFieldMapperInterface::class)
            ->setShared(false)->setPublic(true);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        $ymlLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        if (isset($bundles['EveryWorkflowAuthBundle'])) {
            $ymlLoader->load('auth.yaml');
        }
        if (isset($bundles['EveryWorkflowAdminPanelBundle'])) {
            $ymlLoader->load('admin_panel.yaml');
        }
        $ymlLoader->load('eav.yaml');
    }
}
