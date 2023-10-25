<?php
declare(strict_types=1);

namespace Preventool\Application\Company\SearchCompany;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Repository\CompanyFilter;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class SearchCompanyQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function __invoke(
        SearchCompanyQuery $query
    ): SearchCompanyResponse
    {
        $actionAdminId = new Uuid($query->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        $filter = new CompanyFilter(
            $query->filterById,
            $query->filterByName
        );

        $queryCondition = (new QueryCondition())
            ->setPageSize($query->pageSize)
            ->setCurrentPage($query->currentPage)
            ->setOrderBy($query->orderBy)
            ->setOrderDirection($query->orderDirection);

        $paginatedQueryResponse = $this->companyRepository->searchPaginated(
            $queryCondition,
            $filter
        );

        return new SearchCompanyResponse(
            $paginatedQueryResponse->getTotal(),
            $paginatedQueryResponse->getPages(),
            $paginatedQueryResponse->getCurrentPage(),
            $paginatedQueryResponse->getItems()
        );

    }


}