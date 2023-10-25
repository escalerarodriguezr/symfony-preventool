<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetHealthAndSafetyPolicy;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetHealthAndSafetyPolicyQuery implements Query
{
    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId
    )
    {
    }


}