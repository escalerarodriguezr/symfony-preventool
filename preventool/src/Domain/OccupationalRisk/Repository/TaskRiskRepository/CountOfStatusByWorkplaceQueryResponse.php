<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;

class CountOfStatusByWorkplaceQueryResponse
{

    public function __construct(
        public readonly int $total,
        public readonly int $pending,
        public readonly int $draft,
        public readonly int $revised,
        public readonly int $approved
    )
    {
    }
}