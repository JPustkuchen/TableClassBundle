<?php

namespace JPustkuchen\TableClassBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class TableClassExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
      $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
      $loader->load('services.xml');
    }
}
