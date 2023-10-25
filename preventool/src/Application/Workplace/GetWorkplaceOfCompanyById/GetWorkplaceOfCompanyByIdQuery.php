<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\GetWorkplaceOfCompanyById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetWorkplaceOfCompanyByIdQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId,
        public readonly string $workplaceId
    )
    {
    }
}