<?php
declare(strict_types=1);

namespace Preventool\Application\Process\SearchProcess;

use Preventool\Domain\Shared\Bus\Query\Query;

class SearchProcessQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly ?int $pageSize,
        public readonly ?int $currentPage,
        public readonly ?string $orderBy,
        public readonly ?string $orderDirection,
        public readonly ?string $filterById,
        public readonly ?string $filterByName,
        public readonly ?string $filterByWorkplaceId
    )
    {
    }
}