<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('eav');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('default')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('entity_class')->defaultValue('text')->end()
                        ->scalarNode('attribute_class')->defaultValue('text')->end()
                        ->scalarNode('attribute_field_mapper_class')->defaultValue('text')->end()
                        ->scalarNode('attribute_type')->defaultValue('text')->end()
                        ->scalarNode('attribute_field')->defaultValue('text_field')->end()
                    ->end()
                ->end()
                ->arrayNode('entity_types')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('attribute_types')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('attribute_forms')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('attribute_type_to_form_field_mapper')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
