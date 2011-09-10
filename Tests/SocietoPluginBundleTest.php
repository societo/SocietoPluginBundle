<?php

/**
 * This file is applied CC0 <http://creativecommons.org/publicdomain/zero/1.0/>
 */

namespace Societo\PluginBundle\Tests\Listener;

use Societo\PluginBundle\SocietoPluginBundle;

class SocietoPluginBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPluginDir()
    {
        $bundle = new SocietoPluginBundle('/path/to/plugins/dir');

        $this->assertEquals('/path/to/plugins/dir', $bundle->getPluginDir());
    }
}
