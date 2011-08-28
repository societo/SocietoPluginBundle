<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\PluginBundle\Plugin\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

use Symfony\Component\Config\Definition\Processor;

class SocietoPluginDefaultExtension extends Extension
{
    private $pluginName, $dir;

    public function __construct($pluginName, $dir)
    {
        $this->pluginName = $pluginName;
        $this->dir = $dir;
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator($this->dir.'/Resources/config'));
        try {
            $loader->load('services.xml');
        } catch (\InvalidArgumentException $e) {
            // do nothing
        }
    }

    public function getXsdValidationBasePath()
    {
        return $this->dir.'/Resources/config/';
    }

    public function getAlias()
    {
        return strtolower($this->pluginName);
    }

    public function getNamespace()
    {
        return 'http://schema.societo.org/plugin/'.$this->getAlias();
    }
}
