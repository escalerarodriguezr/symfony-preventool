<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\User;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Exception\UserAlreadyExistsException;
use Preventool\Domain\User\Exception\UserNotFoundException;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Repository\UserRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }


    public function save(User|PasswordAuthenticatedUserInterface $user): void
    {
        try {
            $this->saveEntity($user);
        }catch (UniqueConstraintViolationException $exception){
            UserAlreadyExistsException::withEmail($user->getEmail());
        }
    }

    public function findById(Uuid $id): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['id' => $id->value])) {
            throw UserNotFoundException::fromId($id);
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email])) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }


}