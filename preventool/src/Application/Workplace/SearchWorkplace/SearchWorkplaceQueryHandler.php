<?php

namespace Preventool\Application\Workplace\SearchWorkplace;

use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Workplace\Repository\WorkplaceFilter;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class SearchWorkplaceQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        SearchWorkplaceQuery $query
    ): SearchWorkplaceResponse
    {
        $filter = new WorkplaceFilter(
            $query->filterById,
            $query->filterByCompanyId,
            $query->filterByName
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->workplaceRepository->searchPaginated(
            $queryCondition,
            $filter
        );

        $companyId = !empty($query->filterByCompanyId) ? new Uuid($query->filterByCompanyId) : null;

        return new SearchWorkplaceResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems(),
            $companyId
        );
    }
    
}