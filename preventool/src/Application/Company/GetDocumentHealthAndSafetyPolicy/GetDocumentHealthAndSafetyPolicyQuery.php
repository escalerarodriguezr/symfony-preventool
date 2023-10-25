<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetDocumentHealthAndSafetyPolicy;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetDocumentHealthAndSafetyPolicyQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId
    )
    {
    }
}