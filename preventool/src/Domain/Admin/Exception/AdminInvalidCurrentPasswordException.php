<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Exception;

use Preventool\Domain\Shared\Model\Value\Email;

class AdminInvalidCurrentPasswordException extends \DomainException
{
    public static function withEmail(Email $email): self
    {
        throw new self(sprintf('Invalid currentPassword fot Admin with email %s', $email->value));
    }

}