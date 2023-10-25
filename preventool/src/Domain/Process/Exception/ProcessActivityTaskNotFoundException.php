<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivityTaskNotFoundException extends \DomainException
{
    public static function withId(Uuid $id):self
    {
        return new self(
            sprintf('ProcessActivityTask with id %s not found', $id->value)
        );
    }

}