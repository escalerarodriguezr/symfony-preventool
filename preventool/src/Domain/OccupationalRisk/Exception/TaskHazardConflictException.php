<?php

namespace Preventool\Domain\OccupationalRisk\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskHazardConflictException extends \DomainException
{
    public static function taskAndHazardNotBelongToSameWorkplace(
        Uuid $taskId,
        Uuid $hazardId
    ):self
    {
        return new self(sprintf(
            'Task %s and the Hazard %s do not belong to the same workplace',
            $taskId->value,
            $hazardId->value
        ));
    }

}