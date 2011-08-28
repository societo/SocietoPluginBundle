<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\PluginBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Societo\PluginBundle\Plugin\SocietoPlugin;
use Societo\PluginBundle\Plugin\SocietoSkinPlugin;

/**
 * SocietoPluginBundle
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class SocietoPluginBundle extends Bundle
{
    const DEFAULT_SKIN_PLUGIN_NAME = 'SocietoDefaultSkinPlugin';

    private $pluginDir;

    private $availableSkinPlugin;

    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;

        spl_autoload_register(array($this, 'loadClass'), true, true);
    }

    public function boot()
    {
        $this->container->get('societo.site_config')->setDefault('skin', self::DEFAULT_SKIN_PLUGIN_NAME);
    }

    public function loadClass($name)
    {
        if (0 === strpos($name, 'SocietoPlugin\\')) {
            $parts = explode('\\', $name);
            unset($parts[0]);

            $vendor = $parts[1];
            $pluginName = $parts[2];

            $path = '';
            foreach ($parts as $i => $part) {
                $path .= '/'.$part;
            }

            $basePath = $this->getPluginDir();
            $buildInPath = __DIR__.'/Resources/plugins'.$path.'.php';
            $pharPath = 'phar://'.$basePath.'/'.$vendor.'/'.$vendor.$pluginName.'.phar'.$path.'.php';

            if (file_exists($basePath.$path.'.php')) {
                include_once $basePath.$path.'.php';
            } elseif (file_exists($pharPath)) {
                include_once $pharPath;
            } elseif (file_exists($buildInPath)) {
                include_once $buildInPath;
            }
        }

    }

    public function getPluginsAsBundle()
    {
        $bundles = array();

        $fileIterator = new \DirectoryIterator('glob://'.$this->getPluginDir().'/*/*Plugin');
        $buildInIterator = new \DirectoryIterator('glob://'.__DIR__.'/Resources/plugins/*/*Plugin');
        $pharIterator = new \DirectoryIterator('glob://'.$this->getPluginDir().'/*/*Plugin.phar');

        $iterator = new \AppendIterator();
        $iterator->append($fileIterator);
        $iterator->append($pharIterator);
        $iterator->append($buildInIterator);

        foreach ($iterator as $f) {
            if ($f->isDir()) {
                $vendorName = basename($f->getPath());
                $pluginName = $vendorName.(string)$f;
                $class = 'SocietoPlugin\\'.$vendorName.'\\'.(string)$f.'\\'.$pluginName;
            } else {
                $vendorName = basename($f->getPath());
                $pluginName = $f->getBasename('.phar');
                $class = 'SocietoPlugin\\'.$vendorName.'\\'.substr($pluginName, strlen($vendorName)).'\\'.$pluginName;
            }

            $plugin = new $class();

            if (!($plugin instanceof SocietoPlugin)) {
                throw new \Exception('This is not a Societo Plugin.');
            }

            $bundles[] = $plugin;
        }

        return $bundles;
    }

    public function getPluginDir()
    {
        return $this->pluginDir;
    }

    public function getSkinPlugins()
    {
        $results = array();

        foreach ($this->container->get('kernel')->getBundles() as $bundle) {
            if ($bundle instanceof SocietoSkinPlugin) {
                $results[] = $bundle->getName();
            }
        }

        return $results;
    }

    public function isSupportedSpecifiedSkinPluginResource($pluginName, $resource)
    {
        $plugin = $this->container->get('kernel')->getBundle($pluginName);

        return ($plugin->isSupportedResource($resource));
    }

    public function locateSkinPluginResource($path)
    {
        return $this->container->get('kernel')->locateResource('@'.$this->getAvailableSkinPlugin($path).$path);
    }

    public function getAvailableSkinPlugin($template = null)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $config = $em->getRepository('SocietoBaseBundle:SiteConfig')->findOneBy(array(
            'name' => 'skin',
        ));

        $plugin = self::DEFAULT_SKIN_PLUGIN_NAME;
        if ($config) {
            $plugin = $config->getValue();
            if ($template && !$this->isSupportedSpecifiedSkinPluginResource($plugin, $template)) {
                $plugin = self::DEFAULT_SKIN_PLUGIN_NAME;
            }
        }

        return $plugin;
    }
}
