<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\SearchAdmin;

use Container5MOI6Fx\get_Console_Command_About_LazyService;
use Preventool\Domain\Shared\Bus\Query\Query;

class SearchAdminQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly ?int $pageSize,
        public readonly ?int $currentPage,
        public readonly ?string $orderBy,
        public readonly ?string $orderDirection,
        public readonly ?string $filterById,
        public readonly ?string $filterByEmail,
        public readonly ?string $filterByCreatedAtFrom,
        public readonly ?string $filterByCreatedAtTo,
    )
    {
    }
}