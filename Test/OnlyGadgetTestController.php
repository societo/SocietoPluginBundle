<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\PluginBundle\Test;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Societo\BaseBundle\Util\ArrayAccessibleParameterBag;

class OnlyGadgetTestController extends Controller
{
    public function renderAction($gadget)
    {
        return $this->render('SocietoPluginBundle:Gadget:only_gadget.html.twig', array(
            'gadget' => $gadget,
            'parent_attributes' => $this->get('request')->attributes,
            'parameters' => new ArrayAccessibleParameterBag(array()),
        ));
    }
}
