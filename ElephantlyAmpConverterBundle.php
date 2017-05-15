<?php

namespace Elephantly\AmpConverterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Elephantly\AmpConverterBundle\DependencyInjection\Compiler\TagConverterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ElephantlyAmpConverterBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TagConverterCompilerPass());
    }
}
