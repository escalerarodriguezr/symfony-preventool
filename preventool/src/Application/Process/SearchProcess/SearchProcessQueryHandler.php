<?php
declare(strict_types=1);

namespace Preventool\Application\Process\SearchProcess;

use Preventool\Application\Workplace\SearchWorkplace\SearchWorkplaceResponse;
use Preventool\Domain\Process\Repository\ProcessFilter;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class SearchProcessQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        SearchProcessQuery $query
    ): SearchProcessResponse
    {
        $filter = new ProcessFilter(
            $query->filterByWorkplaceId,
            $query->filterById,
            $query->filterByName,
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->processRepository->searchPaginated(
            $queryCondition,
            $filter
        );

        $workplaceId = !empty($query->filterByWorkplaceId) ? new Uuid($query->filterByWorkplaceId) : null;

        return new SearchProcessResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems(),
            $workplaceId
        );
    }


}