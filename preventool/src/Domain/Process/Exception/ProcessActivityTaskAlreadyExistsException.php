<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Exception;

use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Shared\Model\Value\LongName;

class ProcessActivityTaskAlreadyExistsException extends \DomainException
{
    public static function withNameForProcessActivity(
        LongName $name,
        ProcessActivity $processActivity
    ): self
    {
        return new self(
            sprintf(
                'ProcessActivityTask with name %s already exists for ProcessActivity %s',
                $name->value,
                $processActivity->getId()->value
            )
        );
    }

}