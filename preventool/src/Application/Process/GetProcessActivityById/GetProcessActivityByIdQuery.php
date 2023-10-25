<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetProcessActivityById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetProcessActivityByIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id,
    )
    {
    }
}