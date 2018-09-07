<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPassword implements EventSubscriberInterface
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            User::ON_PRE_CREATED => 'encodeUserPassword',
            User::ON_PRE_UPDATED => 'encodeUserPassword',
        ];
    }

    public function encodeUserPassword(GenericEvent $event)
    {
        $user = $event->getSubject();
        if (!$user instanceof User) {
            return;
        }

        if (null !== $plainPassword = $user->getPassword()) {
            $password = $this->encoder->encodePassword($user, $plainPassword);
            $user->setPassword($password);
        }
    }
}
