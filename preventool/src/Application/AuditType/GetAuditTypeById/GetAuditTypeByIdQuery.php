<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\GetAuditTypeById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetAuditTypeByIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id
    )
    {
    }
}