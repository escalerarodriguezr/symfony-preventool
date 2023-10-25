<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Repository;

use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserRepository
{
    public function save(User|PasswordAuthenticatedUserInterface $user): void;
    public function findByEmail(string $email): ?User;
    public function findById(Uuid $uuid): User;

}