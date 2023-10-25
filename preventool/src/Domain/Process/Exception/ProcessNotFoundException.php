<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class ProcessNotFoundException extends \DomainException
{

    public static function withId(
        Uuid $id
    ):self
    {
        return new self(sprintf(
            'Process with id: %s not found',
            $id->value
        ));
    }

    public static function withIdForWorkplace(
        Workplace $workplace,
        Uuid $id
    ):self
    {
        return new self(sprintf(
            'Process with id: %s not found for workplace: %s',
            $workplace->getId()->value,
            $id->value
        ));
    }

}