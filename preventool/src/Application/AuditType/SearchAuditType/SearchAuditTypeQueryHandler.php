<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\SearchAuditType;

use Preventool\Domain\Audit\Repository\AuditTypeFilter;
use Preventool\Domain\Audit\Repository\AuditTypeRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class SearchAuditTypeQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly AuditTypeRepository $auditTypeRepository
    )
    {
    }

    public function __invoke(
        SearchAuditTypeQuery $query
    ): SearchAuditTypeResponse
    {

        $filter = new AuditTypeFilter(
            $query->filterById,
            $query->filterByCompanyId,
            $query->filterByWorkplaceId
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->auditTypeRepository->searchPaginated(
            $queryCondition,
            $filter
        );


        return new SearchAuditTypeResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems()
        );
    }


}