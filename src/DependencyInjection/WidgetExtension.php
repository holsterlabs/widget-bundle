<?php

namespace Hl\LogReaderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class WidgetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        // $loader = new XmlFileLoader(
        //     $containerBuilder,
        //     new FileLocator(
        //         __DIR__ . '/../Resources/config'
        //     )
        // );
        // $loader->load('services.xml');

        // $configuration = $this->getConfiguration($configs, $containerBuilder);
        // $config = $this->processConfiguration($configuration, $configs);

        // return $config;
    }
}
