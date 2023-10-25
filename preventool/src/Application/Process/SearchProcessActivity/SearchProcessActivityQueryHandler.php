<?php
declare(strict_types=1);

namespace Preventool\Application\Process\SearchProcessActivity;

use Preventool\Application\Process\Response\ProcessActivityResponse;
use Preventool\Domain\Process\Repository\ProcessActivityFilter;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class SearchProcessActivityQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        SearchProcessActivityQuery $query
    ): SearchProcessActivityResponse
    {
        $filter = new ProcessActivityFilter(
            $query->filterByProcessId,
            $query->filterById
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy(ProcessActivityResponse::ACTIVITY_ORDER)
            ->setOrderDirection(QueryCondition::ASC);

        $paginatedQueryResponse = $this->processActivityRepository->searchPaginated(
            $queryCondition,
            $filter
        );

        $processId = !empty($query->filterByProcessId) ? new Uuid($query->filterByProcessId) : null;

        return new SearchProcessActivityResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems(),
            $processId
        );

    }


}