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
                ->scalarNode('openapi')->defaultValue('3.0.3')->end()
                ->arrayNode('info')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('title')->end()
                        ->scalarNode('description')->end()
                        ->scalarNode('termsOfService')->end()
                        ->arrayNode('contact')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->arrayNode('license')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->scalarNode('version')->defaultValue('0.1')->end()
                    ->end()
                ->end()
                ->arrayNode('externalDocs')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('servers')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('url')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('components')
                    ->variablePrototype()
                    ->end()
                ->end()
                ->arrayNode('tags')
                    ->variablePrototype()
                    ->end()
                ->end()
                ->arrayNode('paths')
                    ->variablePrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
