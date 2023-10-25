<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\GetBaselineStudyIndicators;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetBaselineStudyIndicatorsQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId
    )
    {
    }
}