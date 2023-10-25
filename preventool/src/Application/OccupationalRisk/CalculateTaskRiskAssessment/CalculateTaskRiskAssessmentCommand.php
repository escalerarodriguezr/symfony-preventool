<?php

namespace Preventool\Application\OccupationalRisk\CalculateTaskRiskAssessment;

use Preventool\Domain\Shared\Bus\Command\Command;

class CalculateTaskRiskAssessmentCommand implements Command
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskRiskId,
        public readonly string $taskRiskAssessmentId,
        public readonly int $severityIndex,
        public readonly int $peopleExposedIndex,
        public readonly int $procedureIndex,
        public readonly int $trainingIndex,
        public readonly int $exposureIndex
    )
    {
    }
}