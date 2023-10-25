<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetCompanyById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetCompanyByIdQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId
    )
    {
    }
}