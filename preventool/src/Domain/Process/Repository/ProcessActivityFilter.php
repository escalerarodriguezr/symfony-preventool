<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Repository;

class ProcessActivityFilter
{
    public function __construct(
        public readonly ?string $filterByProcessId,
        public readonly ?string $filterById,
    )
    {
    }
}