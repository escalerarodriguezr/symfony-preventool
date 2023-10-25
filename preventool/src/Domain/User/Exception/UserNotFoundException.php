<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class UserNotFoundException extends \DomainException
{


    public static function fromId(Uuid $id): self
    {
        throw new self(\sprintf('User with UUID %s not found', $id->value));
    }

    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf('User with email %s not found', $email));
    }

}