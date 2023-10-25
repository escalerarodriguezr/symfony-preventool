<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Shared\Model\Value\LongName;

class ProcessActivityAlreadyExistsException extends \DomainException
{
    public static function withNameForProcess(LongName $name,Process $process): self
    {
        return new self(sprintf(
            'ProcessActivity with name %s  already exists for process %s',
            $name->value,
            $process->getId()->value
        ));
    }

}