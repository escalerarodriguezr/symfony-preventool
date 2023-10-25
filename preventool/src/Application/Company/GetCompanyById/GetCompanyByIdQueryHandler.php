<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetCompanyById;

use Preventool\Application\Company\Response\CompanyResponse;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetCompanyByIdQueryHandler implements QueryHandler
{

    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        GetCompanyByIdQuery $query
    ): CompanyResponse
    {
        $actionAdminId = new Uuid($query->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
           $actionAdminId
       );

       if( $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT ){
           throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
       }

       $companyId = new Uuid($query->companyId);

       $company = $this->companyRepository->findById(
           $companyId
       );

       return CompanyResponse::createFromCompany($company);

    }

}