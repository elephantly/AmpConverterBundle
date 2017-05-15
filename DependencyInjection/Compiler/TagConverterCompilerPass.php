<?php 

namespace Elephantly\AmpConverterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TagConverterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('elephantly.converters')) {
            return;
        }

        $definition = $container->getDefinition('elephantly.converters');
        $taggedServices = $container->findTaggedServiceIds('elephanty.amp_converter');

        foreach ($taggedServices as $id => $tags) {
            // foreach ($tags as $attributes) {
                $definition->addMethodCall('addConverter', array(
                    new Reference($id)
                ));
            // }
        }
    }
}