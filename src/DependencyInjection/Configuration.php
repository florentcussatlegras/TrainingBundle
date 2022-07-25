<?php

namespace Acme\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('acme');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('foo')->defaultValue('bar')->end()
                ->enumNode('delivery')
                    ->values(['priority', 'expedited', 'standard'])
                ->end()
                ->arrayNode('connections')
                    ->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('host')->end()
                    ->end()
                ->end()
                // ->booleanNode('auto_connect')
                //     ->defaultTrue()
                // ->end()
                // ->floatNode('big_value')
                //     ->max(5E45)
                // ->end()
                // ->integerNode('value_inside_a_range')
                //     ->min(-50)->max(50)
                // ->end()
                // ->enumNode('delivery')
                //     ->values(['standard', 'expedited', 'priority'])
                // ->end()
                // ->arrayNode('connections')
                //     ->arrayPrototype()
                //         ->children()
                //             ->scalarNode('driver')->end()
                //             ->scalarNode('host')->end()
                //         ->end()
                //     ->end()
                // ->end()
            ->end()
        ;       

        return $treeBuilder;
    }
}

