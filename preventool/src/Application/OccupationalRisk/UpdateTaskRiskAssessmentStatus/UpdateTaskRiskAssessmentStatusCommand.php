<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\UpdateTaskRiskAssessmentStatus;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateTaskRiskAssessmentStatusCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskRiskId,
        public readonly string $status
    )
    {
    }
}