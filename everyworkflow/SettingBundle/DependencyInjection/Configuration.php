<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setting');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('menu')
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
