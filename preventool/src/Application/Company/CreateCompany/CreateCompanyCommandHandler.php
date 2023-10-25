<?php
declare(strict_types=1);

namespace Preventool\Application\Company\CreateCompany;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Company\Model\Value\LegalName;
use Preventool\Domain\Company\Model\Value\Sector;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Company\Service\CreateHealthAndSafetyPolicyService;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CreateCompanyCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository,
        private readonly CreateHealthAndSafetyPolicyService $createHealthAndSafetyPolicyService
    )
    {
    }

    public function __invoke(
        CreateCompanyCommand $command
    ): void
    {

        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        if( $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $company = new Company(
            new Uuid($command->id),
            new Name($command->name),
            new LegalName($command->legalName),
            new LegalDocument($command->legalDocument),
            new Address($command->address),
            new Sector($command->sector)
        );

        $company->setCreatorAdmin(
            $actionAdmin
        );

        $this->companyRepository->save(
            $company
        );

        $this->createHealthAndSafetyPolicyService->__invoke(
            $company,
            $actionAdmin
        );
    }

}