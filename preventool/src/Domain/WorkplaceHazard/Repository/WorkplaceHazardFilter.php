<?php
declare(strict_types=1);

namespace Preventool\Domain\WorkplaceHazard\Repository;

class WorkplaceHazardFilter
{

    public function __construct(
        public readonly ?string $filterById = null,
        public readonly ?string $filterByWorkplaceId= null,
        public readonly ?string $filterByNotHasTaskHazardWithTaskId = null
    )
    {
    }
}