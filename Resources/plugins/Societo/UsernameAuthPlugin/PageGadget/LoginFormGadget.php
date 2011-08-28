<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace SocietoPlugin\Societo\UsernameAuthPlugin\PageGadget;

use Societo\PageBundle\PageGadget\AbstractPageGadget;
use Symfony\Component\Security\Core\SecurityContext;

/**
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class LoginFormGadget extends AbstractPageGadget
{
    protected $caption = 'Username Login Form';
    protected $description = 'Login form by using username and password';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('SocietoUsernameAuthPlugin:PageGadget:login_form.html.twig', array(
            'gadget' => $gadget,
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}
