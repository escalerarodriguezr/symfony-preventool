<?php
declare(strict_types=1);

namespace Preventool\Application\Company\UpdateCompanyById;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Company\Model\Value\LegalName;
use Preventool\Domain\Company\Model\Value\Sector;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UpdateCompanyByIdCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function __invoke(
        UpdateCompanyByIdCommand $updateCompanyByIdCommand
    ): void
    {
        $actionAdminId = new Uuid(
            $updateCompanyByIdCommand->actionAdminId
        );

        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        if( $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $companyId = new Uuid(
            $updateCompanyByIdCommand->id
        );

        $company = $this->companyRepository->findById(
            $companyId
        );

        if( !empty($updateCompanyByIdCommand->name) ){
            $company->setName(
                new Name($updateCompanyByIdCommand->name)
            );
        }

        if( !empty($updateCompanyByIdCommand->legalName) ){
            $company->setLegalName(
                new LegalName($updateCompanyByIdCommand->legalName)
            );
        }

        if( (!empty($updateCompanyByIdCommand->legalDocument)) ){
            $company->setLegalDocument(
                new LegalDocument($updateCompanyByIdCommand->legalDocument)
            );
        }

        if( !empty($updateCompanyByIdCommand->address) ){
            $company->setAddress(
                new Address($updateCompanyByIdCommand->address)
            );
        }

        if( !empty($updateCompanyByIdCommand->sector) ){
            $company->setSector(
                new Sector($updateCompanyByIdCommand->sector)
            );
        }

        $company->setUpdaterAdmin(
            $actionAdmin
        );

        $this->companyRepository->save(
            $company
        );

    }


}