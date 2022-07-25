<?php

namespace App\DependencyInjection;

class AcmeBlogExtension2 extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if(isset($bundles['TwigBundle'])) {

            foreach($container->getExtensions() as $name => $extension) {

                if($name == 'quantity_converter') {

                    $container->prependExtensionConfig($name, [
                        'foo' => true
                    ]);
                }

            }
        }

        $configs = $container->getExtensionConfig($this->getAlias());

        foreach(array_reverse($configs) as $config) {
            if($config['foo'] == 'baz') {
                $container->prependExtensionConfig('quantity_converter', [
                    'foo' => (bool)$config['foo']
                ]);
            }
        }

    }

    public function load(ContainerBuilder $container, array $configs)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->hasDefinition('acme_blog.mon_service');
        $container->has('acme_blog.mon_service');
        $monService = $container->getDefinition('acme_blog.mon_service');
        $monService = $container->findDefinition('acme_blog.mon_service');

        $monService->replaceArgument(0, $config['connections']);
        $monService->addMethodCall('addDatas', ['foo', 'bar']);

        $container->setAlias('app.alias', \App\Service\SomeService1::class);

        $someService2 = new Definition(\App\Service\SomeService2::class, [
            'foo1' => 'bar1',
            'foo2' => 'bar2'
        ]);
        $container->setDefinition('app.some_service2', $someService2);
        //shortcut
        $container->register('app.some_service2', \App\Service\SomeService2::class);

        $monService2->setArgument('foo1', 'baz3');
        $monService2->addArgument('baz4');
        $monService2->replaceArgument(0, 'baz5');
        $monService2->setArguments(['baz6', 'baz7']);

        $monService2->addMethodCall('setFoo1', ['bar_call']);

        $monService3 = new Definition(\App\Service\SomeService3::class);
        $monService3->setClass(\App\Service\SomeService2::class);
        $class = $monService3->getClass();

        $definition = new Definition(DoctrinecConfigManager::class, [
            new Reference('doctrine'),
            '%app.config_table_name%'
        ]);
    }
}