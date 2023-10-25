<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Exception;

class UserAccountNotActiveException extends \DomainException
{
    public static function fromLoginService(string $email): self
    {
        throw new self(\sprintf('User %s account is not active', $email));
    }

    public static function fromSecurity(string $id): self
    {
        throw new self(\sprintf('User %s account is not active', $id));
    }

    public static function fromHttpActionUserService(string $email): self
    {
        throw new self(\sprintf('User %s account is not active', $email));
    }

}