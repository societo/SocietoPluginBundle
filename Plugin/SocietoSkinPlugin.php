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
 * SocietoSkinPlugin
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
abstract class SocietoSkinPlugin extends SocietoPlugin
{
    public function isSupportedResource($resource)
    {
        return true;
    }
}
