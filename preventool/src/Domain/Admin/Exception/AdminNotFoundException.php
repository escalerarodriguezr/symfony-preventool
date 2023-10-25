<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class AdminNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        throw new self(sprintf('Admin with id "%s" not found', $id->value));
    }

}