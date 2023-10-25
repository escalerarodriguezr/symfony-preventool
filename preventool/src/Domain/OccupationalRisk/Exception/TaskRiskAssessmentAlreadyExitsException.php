<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskRiskAssessmentAlreadyExitsException extends \DomainException
{
    public static function withTaskRiskId(Uuid $taskRiskId): self
    {
        return new self(sprintf(
            'TaskRiskAssessment for taskRisk %s already exists',
            $taskRiskId->value,
        ));
    }

}