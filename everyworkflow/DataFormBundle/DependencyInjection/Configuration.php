<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('data_form');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('default')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('section')->defaultValue('base_section')->end()
                        ->scalarNode('field')->defaultValue('text_field')->end()
                    ->end()
                ->end()
                ->arrayNode('sections')
                    ->useAttributeAsKey('section_type')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('fields')
                    ->useAttributeAsKey('field_type')
                    ->scalarPrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
