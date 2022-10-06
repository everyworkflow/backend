<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('swagger');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('info')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('title')->end()
                        ->scalarNode('description')->end()
                        ->scalarNode('termsOfService')->end()
                        ->arrayNode('contact')
                            ->useAttributeAsKey('type')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->arrayNode('license')
                            ->useAttributeAsKey('type')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->scalarNode('version')->defaultValue('0.1')->end()
                    ->end()
                ->end()
                ->arrayNode('externalDocs')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('servers')
                    ->useAttributeAsKey('type')
                    ->scalarPrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
