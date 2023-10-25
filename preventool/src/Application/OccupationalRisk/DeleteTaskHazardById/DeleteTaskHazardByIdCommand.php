<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\DeleteTaskHazardById;

use Preventool\Domain\Shared\Bus\Command\Command;

class DeleteTaskHazardByIdCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskHazardId
    )
    {
    }
}