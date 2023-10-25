<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\GetTaskRiskAssessmentByTaskRiskId;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetTaskRiskAssessmentByTaskRiskIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskRiskId
    )
    {
    }
}