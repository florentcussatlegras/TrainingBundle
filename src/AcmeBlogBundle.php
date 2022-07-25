<?php

namespace Acme\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Acme\BlogBundle\DependencyInjection\AcmeBlogExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Acme\BlogBundle\DependencyInjection\Compiler\AcmeBlogCompilerPass;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class AcmeBlogBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {   
        dump('build() in acme blog bundle');

        $container->addCompilerPass(new AcmeBlogCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 10);

        /*
            OPTIMIZATION: resolving references within the definitions
            
                PassConfig::TYPE_BEFORE_OPTIMIZATION (default)
                PassConfig::TYPE_OPTIMIZE

            REMOVAL: removing private aliases and unused services
            
                PassConfig::TYPE_BEFORE_REMOVING
                PassConfig::TYPE_REMOVE
                PassConfig::TYPE_AFTER_REMOVING

            // FirstPass is executed after SecondPass because its priority is lower
                $container->addCompilerPass(
                    new FirstPass(), PassConfig::TYPE_AFTER_REMOVING, 10
                );
                $container->addCompilerPass(
                    new SecondPass(), PassConfig::TYPE_AFTER_REMOVING, 30
                );
        */
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension)
        {
            $this->extension = new AcmeBlogExtension();
        }

        return $this->extension;
    }
}