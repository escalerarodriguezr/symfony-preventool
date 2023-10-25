<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\SearchAdmin;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminFilter;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class SearchAdminHandler implements QueryHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        SearchAdminQuery $query
    ): SearchAdminResponse
    {

        $actionAdminId = new Uuid($query->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        if ($actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $filter = new AdminFilter(
            $query->filterById,
            $query->filterByEmail,
            $query->filterByCreatedAtFrom,
            $query->filterByCreatedAtTo
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->adminRepository->searchPaginated(
            $queryCondition,
            $filter
        );

        return new SearchAdminResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems()
        );
    }

}