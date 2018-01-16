<?php

namespace Elephantly\AmpConverterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ElephantlyAmpConverterExtension extends Extension
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

        $converterDefinition = new Definition('Elephantly\AmpConverterBundle\Converter\AmpConverter');
        $converterDefinition
           ->setArguments(array(
                new Reference('elephantly.converters'),
                $config,
                new Reference('elephantly.amp_tag_cleaner')
           ))
       ;
       $container->setDefinition('elephantly.amp_converter', $converterDefinition);
    }
}
