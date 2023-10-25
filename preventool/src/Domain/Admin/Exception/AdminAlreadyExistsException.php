<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Exception;

use Preventool\Domain\Shared\Model\Value\Email;

class AdminAlreadyExistsException extends \DomainException
{
    public static function withEmail(Email $email): self
    {
        throw new self(sprintf('Admin with email %s already exists', $email->value));
    }

}