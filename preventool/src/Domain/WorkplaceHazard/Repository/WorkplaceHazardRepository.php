<?php

namespace Preventool\Domain\WorkplaceHazard\Repository;

use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;
interface WorkplaceHazardRepository
{
    public function save(WorkplaceHazard $model): void;
    public function findById(Uuid $id): WorkplaceHazard;

    public function searchPaginated(
        QueryCondition $queryCondition,
        WorkplaceHazardFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;

}