<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Repository;

use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Domain\Workplace\Model\Workplace;

interface ProcessRepository
{
    public function save(Process $model): void;
    public function delete(Process $model): void;
    public function findById(Uuid $id): Process;
    public function findByWorkplaceAndId(Workplace $workplace,Uuid $id): Process;

    public function searchPaginated(
        QueryCondition $queryCondition,
        ProcessFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;

    public function findByWorkplaceAndNameOrNull(Workplace $workplace, LongName $name): ?Process;

}