<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Repository;

class ProcessFilter
{
    public function __construct(
        public readonly ?string $filterByWorkplaceId,
        public readonly ?string $filterById,
        public readonly ?string $filterByName
    )
    {
    }
}