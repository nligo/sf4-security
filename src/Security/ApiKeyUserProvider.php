<?php
/**
 * Created by PhpStorm.
 * User: linpoo
 * Date: 2018/9/7
 * Time: 下午2:25.
 */

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->em = $entityManager;
        $this->logger = $logger;
    }

    public function getUsernameForApiKey($apiKey)
    {
        $user = $this->em->getRepository(\App\Entity\User::class)->findOneBy(['apiKey' => $apiKey]);
        if (is_null($user)) {
            return false;
        }
        $username = $user->getUsername() ?? '';

        return $username;
    }

    public function loadUserByUsername($username)
    {
        return new User(
            $username,
            null,
            // the roles for the user - you may choose to determine
            // these dynamically somehow based on the user
            array('ROLE_API')
        );
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
