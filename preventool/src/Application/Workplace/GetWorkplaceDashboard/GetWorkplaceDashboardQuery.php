<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\GetWorkplaceDashboard;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetWorkplaceDashboardQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId
    )
    {
    }
}