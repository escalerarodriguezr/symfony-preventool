<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\GetWorkplaceBaselineStudyIndicatorsByCategory;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetWorkplaceBaselineStudyIndicatorsByCategoryQuery implements Query
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId,
        public readonly string $category
    )
    {
    }
}