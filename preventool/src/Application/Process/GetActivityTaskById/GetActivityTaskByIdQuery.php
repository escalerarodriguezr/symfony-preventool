<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetActivityTaskById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetActivityTaskByIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskId
    )
    {
    }
}