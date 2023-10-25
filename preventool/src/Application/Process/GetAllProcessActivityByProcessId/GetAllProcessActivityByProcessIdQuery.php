<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetAllProcessActivityByProcessId;

use Preventool\Domain\Shared\Bus\Command\Command;
use Preventool\Domain\Shared\Bus\Query\Query;

class GetAllProcessActivityByProcessIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $processId
    )
    {
    }
}