<?php

namespace Acme\BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class AcmeBlogExtension extends Extension implements PrependExtensionInterface, CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        dump('process() in acme blog extension');
    }

    public function prepend(ContainerBuilder $container)
    {
        dump('prepend() in acme blog extension');
        $bundles = $container->getParameter('kernel.bundles');

        if(isset($bundles['TwigBundle'])) {
            foreach($container->getExtensions() as $name => $extensions) {
                if($name == 'quantity_converter') {

                    // ajoute ['baz' => true] ) la config du bundle florent_quantity_converter
                    $container->prependExtensionConfig($name, ['foo' => false]);

                }
            }
        }

        $configs = $container->getExtensionConfig($this->getAlias());

        // si foo => baz dans la config de ce bundle acme_hello alors on
        // ajoute foo => baz à la config de FlorentQuantityConverteBundle
        foreach(array_reverse($configs) as $config) {
            if($config['foo'] == 'baz') {
                $container->prependExtensionConfig('quantity_converter', [
                    'foo' => (bool)$config['foo']
                ]);
            }
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        dump('load in acme blog extension');
        // $container->registerForAutoconfiguration(CustomInterface::class)
        //             ->addTag('app.custom_tag');
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);


        // Definition à partir d'un service du bundle

        $container->hasDefinition('acme_blog.mon_service');
        $container->has('acme_blog.mon_service');
        $monService = $container->findDefinition('acme_blog.mon_service');
        $monService = $container->getDefinition('acme_blog.mon_service');

        $monService->setArgument(1, $config['connections']);
        // $monService->addMethodCall('setEventDispatcher', []);
        $monService->addMethodCall('addDatas', [
            ['foo', 'bar']
        ]);

        // Definition créer à partir de service de l'application

        $container->setAlias('app.alias', SomeService1::class);
        
        $monService2 = new Definition(\App\Service\SomeService2::class, [
            'foo1' => 'baz1',
            'foo2' => 'baz2' 
        ]);
        $container->setDefinition('app.some_service2', $monService2);
        // shortcut for the previous method
        $container->register('app.some_service2', \App\Service\SomeService2::class);

        $monService2->setArgument('foo1', 'baz3');
        $monService2->addArgument('baz4');
        $monService2->replaceArgument(0, 'baz5');
        $monService2->setArguments(['baz6', 'baz7']);

        $monService2->addMethodCall('setFoo1', ['bar_call']);

        $monService3 = new Definition(\App\Service\SomeService2::class);
        $monService3->setClass(\App\Service\SomeService3::class);
        $class = $monService3->getClass();

        $definition = new Definition(DoctrineConfigManager::class, [
            new Reference('doctrine'),
            '%app.config_table_name%'
        ]);

        // $this->addAnnotatedClassesToCompile([
        //     'Acme\BlogBundle\AnnotationController'
        // ]);
    }

    public function getAlias(): string
    {
        return 'florent_acme_blog';
    }

    public function getNamespace()
    {
        return 'http://acme_company.com/schema/dic/hello';
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }
}