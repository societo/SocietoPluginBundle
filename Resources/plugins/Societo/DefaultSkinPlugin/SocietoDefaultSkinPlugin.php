<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace SocietoPlugin\Societo\DefaultSkinPlugin;

use Societo\PluginBundle\Plugin\SocietoSkinPlugin;

class SocietoDefaultSkinPlugin extends SocietoSkinPlugin
{
    public function getAuthor()
    {
        return 'Kousuke Ebihara';
    }

    public function getVersion()
    {
        return '0.5.0';
    }
}
