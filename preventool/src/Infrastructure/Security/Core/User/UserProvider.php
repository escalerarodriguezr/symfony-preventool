<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Security\Core\User;


use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }

    public function loadUserByIdentifier(
        string $identifier
    ): UserInterface
    {
        try {
            return $this->userRepository->findByEmail($identifier);
        } catch (NotFoundHttpException $e) {
            throw new UserNotFoundException(\sprintf('User with email %s not found', $identifier));
        }
    }

    public function refreshUser(
        UserInterface $user
    ): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(\sprintf('Instances of %s are not supported', \get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function upgradePassword(
        PasswordAuthenticatedUserInterface $user,
        string $newHashedPassword
    ): void
    {
        $user->setPassword($newHashedPassword);

        $this->userRepository->save($user);
    }

    public function supportsClass(
        string $class
    ): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

}