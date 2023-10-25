<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Repository;

use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;

interface CompanyRepository
{

    public function save(Company $company): void;
    public function findById(Uuid $id): Company;
    public function delete(Company $company): void;

    public function searchPaginated(
        QueryCondition $queryCondition,
        CompanyFilter $filter,
        bool $fetchJoinCollections
    ): PaginatedQueryResponse;
    public function findByLegalDocumentOrNull(LegalDocument $legalDocument): ?Company;

}