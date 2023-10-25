<?php
declare(strict_types=1);

namespace Preventool\Domain\Audit\Repository;

class AuditTypeFilter
{


    public function __construct(
        public readonly ?string $filterById,
        public readonly ?string $filterByCompanyId,
        public readonly ?string $filterByWorkplaceId

    )
    {
    }
}