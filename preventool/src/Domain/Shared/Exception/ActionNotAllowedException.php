<?php

namespace Preventool\Domain\Shared\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class ActionNotAllowedException extends \DomainException
{
    public static function fromApplicationUseCase(Uuid $id): self
    {
        throw new self(\sprintf('Admin with UUID %s account does not have permissions', $id->value));
    }

}