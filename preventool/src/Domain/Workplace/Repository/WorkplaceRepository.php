<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Repository;

use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Domain\Workplace\Model\Workplace;

interface WorkplaceRepository
{
    public function save(Workplace $workplace): void;
    public function findById(Uuid $id): Workplace;
    public function delete(Workplace $workplace): void;

    public function searchPaginated(
        QueryCondition $queryCondition,
        WorkplaceFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;

}