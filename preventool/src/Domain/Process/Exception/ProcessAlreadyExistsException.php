<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Workplace\Model\Workplace;

class ProcessAlreadyExistsException extends \DomainException
{
    public static function withNameForWorkplace(
        LongName $name,
        Workplace $workplace
    ):self
    {
        return new self(sprintf(
            'Process with name: %s already exists for workplace: %s',
            $name->value,
            $workplace->getId()->value
        ));
    }

}