<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\CreateTaskHazard;

use Preventool\Domain\Shared\Bus\Command\Command;

class CreateTaskHazardCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskHazardId,
        public readonly string $taskId,
        public readonly string $hazardId
    )
    {
    }
}