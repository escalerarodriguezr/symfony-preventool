<?php
declare(strict_types=1);

namespace Preventool\Domain\Audit\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class AuditTypeNotFoundException extends \DomainException
{
    public static function withId(Uuid $id):self
    {
        return new self(
            sprintf('Audit Type with id %s not found', $id->value)
        );
    }

}