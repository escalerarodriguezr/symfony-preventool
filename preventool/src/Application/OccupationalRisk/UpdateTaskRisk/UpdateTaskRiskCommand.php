<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\UpdateTaskRisk;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateTaskRiskCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskRiskId,
        public readonly ?string $name,
        public readonly ?string $observations,
        public readonly ?string $legalRequirement,
        public readonly ?string $hazardName,
        public readonly ?string $hazardDescription
    )
    {
    }
}