<?php

namespace Acme\BlogBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AcmeBlogCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // $definition = $container->getDefinition('florent.quantity_converter');

        // $references = [];

        // foreach($container->findTaggedServiceIds('florent_unit_measure_provider') as $id => $tags) {

        //     $reference = new Reference($id);
        //     $references[] = $reference;

        // }

        // $definition->setArgument(0, $references);
    }
}