<?php
declare(strict_types=1);

namespace Preventool\Application\Company\DeleteCompany;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;

class DeleteCompanyCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function __invoke(
        DeleteCompanyCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        if( $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $companyId = new Uuid($command->companyId);
        $company = $this->companyRepository->findById($companyId);
        $company->setUpdaterAdmin($actionAdmin);
        $this->companyRepository->save($company);
        $this->companyRepository->delete($company);
    }


}