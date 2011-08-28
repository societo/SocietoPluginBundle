<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\PluginBundle\Twig\Extension;

class PluginExtension extends \Twig_Extension
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'societo_plugin';
    }

    public function getFunctions()
    {
        return array(
            'skin_template_path' => new \Twig_Function_Method($this, 'getSkinPluginTemplatePath'),
        );
    }

    public function getSkinPluginTemplatePath($template)
    {
        $bundle = $this->container->get('kernel')->getBundle('SocietoPluginBundle');

        return $bundle->getAvailableSkinPlugin($template).'::'.$template;
    }
}
