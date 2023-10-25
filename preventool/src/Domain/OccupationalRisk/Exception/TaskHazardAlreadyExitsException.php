<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskHazardAlreadyExitsException extends \DomainException
{
    public static function withTaskIdAndHazardId(Uuid $taskId, Uuid $hazardId): self
    {
        return new self(sprintf(
            'TaskHazard for task %s and hazard %s already exists',
            $taskId->value,
            $hazardId->value
        ));
    }

}