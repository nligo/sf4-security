<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class User extends Fixture
{
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new \App\Entity\User();
        $user->setUsername('admin');
        $user->setEmail('admin@coffey.com');
        $user->setIsActive(true);
        $user->setPhone('13000000000');
        $user->setPassword('123456');
        $user->setApiKey('admin');
        $this->dispatcher->dispatch(\App\Entity\User::ON_PRE_CREATED, new GenericEvent($user));
        $manager->persist($user);
        $manager->flush();
    }
}
