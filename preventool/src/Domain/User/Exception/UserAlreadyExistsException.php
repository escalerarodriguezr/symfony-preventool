<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Exception;

use Preventool\Domain\Shared\Model\Value\Email;

class UserAlreadyExistsException extends \DomainException
{
    public static function withEmail(Email $email): self
    {
        throw new self(sprintf('User with email %s already exists', $email->value));
    }

}