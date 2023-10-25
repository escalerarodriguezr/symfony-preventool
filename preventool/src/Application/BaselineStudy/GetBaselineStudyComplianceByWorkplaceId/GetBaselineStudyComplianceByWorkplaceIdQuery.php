<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\GetBaselineStudyComplianceByWorkplaceId;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetBaselineStudyComplianceByWorkplaceIdQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId
    )
    {
    }
}