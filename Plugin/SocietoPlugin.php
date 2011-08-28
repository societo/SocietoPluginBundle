<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\PluginBundle\Plugin;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * SocietoPlugin
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
abstract class SocietoPlugin extends Bundle
{
    abstract public function getAuthor();

    abstract public function getVersion();

    public function getDescription()
    {
        return '';
    }

    public function getConfigRoute()
    {
        return '';
    }

    public function getContainerExtension()
    {
        $extension = parent::getContainerExtension();
        if ($extension) {
            return $extension;
        }

        $ref = new \ReflectionObject($this);
        $dirname = dirname($ref->getFileName());
        $this->extension = new DependencyInjection\SocietoPluginDefaultExtension($this->getName(), $dirname);

        return $this->extension;
    }
}
