<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Repository;

use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;

interface ProcessActivityRepository
{
    public function save(ProcessActivity $processActivity): void;
    public function findById(Uuid $id): ProcessActivity;
    public function delete(ProcessActivity $processActivity): void;

    public function getAllByProcessId(Uuid $processId): array;

    public function searchPaginated(
        QueryCondition $queryCondition,
        ProcessActivityFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;

}