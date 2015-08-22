<?php

namespace NilPortugues\Symfony2\JsonApiBundle\DependencyInjection;

use NilPortugues\Api\Mapping\Mapper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NilPortuguesSymfony2JsonApiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->setMappings($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $config
     */
    private function setMappings(ContainerBuilder $container, $config)
    {
        if (true === file_exists($config['mappings'])) {
            $finder = new Finder();
            $finder->files()->in($config['mappings']);
            $loadedMappings = [];

            foreach ($finder as $file) {
                /* @var \Symfony\Component\Finder\SplFileInfo $file */
                $mapping = file_get_contents($file->getPathname());
                $mapping = Yaml::parse($mapping);
                $loadedMappings[] = $mapping['mapping'];
            }

            $definition = new Definition();
            $definition->setClass('NilPortugues\Api\Mapping\Mapper');
            $args = array($loadedMappings);
            $definition->setArguments($args);
            $definition->setLazy(true);

            $container->setDefinition('nil_portugues.api.mapping.mapper', $definition);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'nilportugues_json_api';
    }
}
