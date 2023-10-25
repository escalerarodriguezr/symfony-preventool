<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskRiskAssessmentNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        return new self(
            sprintf('TaskRiskAssessment with id %s not found', $id->value)
        );
    }

    public static function withTaskRiskId(Uuid $id): self
    {
        return new self(
            sprintf('TaskRiskAssessment with taskRiskId %s not found', $id->value)
        );
    }

}