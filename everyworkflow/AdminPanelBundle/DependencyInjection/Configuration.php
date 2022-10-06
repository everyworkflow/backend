<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('admin_panel');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('sidebar_menu')
                    ->normalizeKeys(false)
                    ->useAttributeAsKey('type')
                    ->arrayPrototype()
                    ->scalarPrototype()
                    ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
