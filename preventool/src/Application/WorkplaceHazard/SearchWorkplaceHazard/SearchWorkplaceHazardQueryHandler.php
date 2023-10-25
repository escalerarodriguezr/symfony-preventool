<?php
declare(strict_types=1);

namespace Preventool\Application\WorkplaceHazard\SearchWorkplaceHazard;

use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardFilter;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardRepository;

class SearchWorkplaceHazardQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceHazardRepository $workplaceHazardRepository
    )
    {
    }

    public function __invoke(
        SearchWorkplaceHazardQuery $query
    ): SearchWorkplaceHazardResponse
    {

        $filter = new WorkplaceHazardFilter(
            $query->filterById,
            $query->filterByWorkplaceId,
            $query->filterByNotHasTaskHazardId
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->workplaceHazardRepository->searchPaginated(
            $queryCondition,
            $filter
        );


        $workplaceId = !empty($query->filterByWorkplaceId) ? new Uuid($query->filterByWorkplaceId) : null;

        return new SearchWorkplaceHazardResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems(),
            $workplaceId
        );


    }


}