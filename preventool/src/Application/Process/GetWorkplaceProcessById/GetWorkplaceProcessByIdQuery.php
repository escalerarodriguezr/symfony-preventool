<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetWorkplaceProcessById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetWorkplaceProcessByIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId,
        public readonly string $processId
    )
    {
    }
}