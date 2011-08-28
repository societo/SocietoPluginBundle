<?php

/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace SocietoPlugin\Societo\UsernameAuthPlugin;

use Societo\PluginBundle\Plugin\SocietoAuthPlugin;
use Societo\AuthenticationBundle\RegistrationEvents;

class SocietoUsernameAuthPlugin extends SocietoAuthPlugin
{
    public function boot()
    {
        parent::boot();

        $container = $this->container;
        $dispatcher = $container->get('event_dispatcher');

        $dispatcher->addListener(RegistrationEvents::FORM_BUILD, function($event) {
            $event->getBuilder()
                ->add('username', 'text')
                ->add('password', 'password')
            ;
        });

        $dispatcher->addListener('onSocietoRegistrationDataFlush', function($event) use ($container) {
            $em = $event->getEntityManager();
            $signUp = $event->getSignUp();

            $parameters = $signUp->getParameters();

            $factory = $container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($event->getAccount());
            $password = $encoder->encodePassword($parameters['password'], $event->getAccount()->getSalt());

            $namespace = 'SocietoUsernameAuthPlugin';
            $em->persist(new \Societo\BaseBundle\Entity\MemberConfig($event->getMember(), $namespace, 'username', $signUp->getUsername()));
            $em->persist(new \Societo\BaseBundle\Entity\MemberConfig($event->getMember(), $namespace, 'password', $password));
            $em->flush();
        });
    }

    public function getAuthor()
    {
        return 'Kousuke Ebihara';
    }

    public function getVersion()
    {
        return '0.5.0';
    }
}
