<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\GetTaskHazardsByTaskId;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetTaskHazardsByTaskIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskId
    )
    {
    }
}