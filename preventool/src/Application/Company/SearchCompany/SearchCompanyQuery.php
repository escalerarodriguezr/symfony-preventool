<?php
declare(strict_types=1);

namespace Preventool\Application\Company\SearchCompany;

use Preventool\Domain\Shared\Bus\Query\Query;

class SearchCompanyQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly ?int $pageSize,
        public readonly ?int $currentPage,
        public readonly ?string $orderBy,
        public readonly ?string $orderDirection,
        public readonly ?string $filterById,
        public readonly ?string $filterByName
    )
    {
    }
}