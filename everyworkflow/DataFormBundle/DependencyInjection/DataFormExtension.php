<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\DependencyInjection;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProvider;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataFormBundle\Section\BaseSectionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DataFormExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $definition = $container->getDefinition(DataFormConfigProvider::class);
        $definition->addArgument($mergedConfig);

        $container->registerForAutoconfiguration(BaseSectionInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(BaseFieldInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(OptionInterface::class)
            ->setShared(false)->setPublic(true);
        $container->registerForAutoconfiguration(FormInterface::class)
            ->setShared(false)->setPublic(true);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $ymlLoader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $ymlLoader->load('data_form.yaml');
    }
}
