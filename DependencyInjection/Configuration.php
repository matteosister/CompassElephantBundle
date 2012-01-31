<?php

namespace Cypress\CompassElephantBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cypress_compass_elephant');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->arrayNode('compass_projects')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('path')->isRequired()->end()
                            ->scalarNode('config_file')->defaultValue('config.rb')->end()
                            ->scalarNode('staleness_checker')->defaultValue('finder')->end()
                            ->scalarNode('auto_init')->defaultValue(true)->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('compass_binary_path')->defaultValue(null)->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
