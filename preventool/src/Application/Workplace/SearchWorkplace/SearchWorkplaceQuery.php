<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\SearchWorkplace;

use Preventool\Domain\Shared\Bus\Query\Query;

class SearchWorkplaceQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly ?int $pageSize,
        public readonly ?int $currentPage,
        public readonly ?string $orderBy,
        public readonly ?string $orderDirection,
        public readonly ?string $filterById,
        public readonly ?string $filterByCompanyId,
        public readonly ?string $filterByName
    )
    {
    }
}