<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetAllProcessActivityTasksByProcessActivityId;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetAllProcessActivityTasksByProcessActivityIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $processActivityId
    )
    {
    }
}