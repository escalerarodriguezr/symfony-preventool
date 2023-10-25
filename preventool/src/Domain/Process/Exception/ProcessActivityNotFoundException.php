<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class ProcessActivityNotFoundException extends \DomainException
{

    public static function withId(
        Uuid $id
    ):self
    {
        return new self(sprintf(
            'Process Activity with id: %s not found',
            $id->value
        ));
    }
}