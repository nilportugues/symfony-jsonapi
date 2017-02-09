<?php

namespace NilPortugues\Symfony\JsonApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    const DEFAULT_PATH = '%kernel.root_dir%/config/serializer/';
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('nilportugues_json_api')
                ->children()
                    ->arrayNode('mappings')
                        ->prototype('scalar')
                        ->isRequired()
                        ->cannotBeEmpty()
                        ->end()
                    ->end()
                    ->scalarNode('attributes_case')
                    ->defaultValue('snake_case')
                    ->validate()
                        ->ifNotInArray(['snake_case', 'keep_case']) // @TODO: implement forcing camelCase and hypen-case.
                        ->thenInvalid('Invalid case setting %s, valid values are: snake_case, keep_case')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
