<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Repository;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;

interface AdminRepository
{
    public function save(Admin $admin): void;
    public function findById(Uuid $id): Admin;
    public function searchPaginated(
        QueryCondition $queryCondition,
        AdminFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;

    public function findByEmailOrNull(Email $email): ?Admin;

}