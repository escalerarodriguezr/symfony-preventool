<?php
declare(strict_types=1);

namespace Preventool\Application\Company\ApproveHealthAndSafetyPolicy;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Company\Repository\HealthAndSafetyPolicyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ApproveHealthAndSafetyPolicyCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository,
        private readonly HealthAndSafetyPolicyRepository $healthAndSafetyPolicyRepository
    )
    {
    }

    public function __invoke(
        ApproveHealthAndSafetyPolicyCommand $command
    ): void
    {
        $actionAdminId = new Uuid(
            $command->actionAdminId
        );
        $companyId = new Uuid(
            $command->companyId
        );

        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        $company = $this->companyRepository->findById(
            $companyId
        );

        $policy = $this->healthAndSafetyPolicyRepository->findByCompanyOrNull(
            $company
        );

        if(empty($policy)){
            throw HealthAndSafetyPolicyOfCompanyNotFoundException::withCompanyId(
                $companyId
            );
        }

        if(empty($policy->getDocumentResource())){
            throw HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException::withCompanyId(
                $companyId
            );
        }

        if ($policy->getStatus()->value === DocumentStatus::APPROVED){
            $newStatus = new DocumentStatus(DocumentStatus::DRAFT);
        }else{
            $newStatus = new DocumentStatus(DocumentStatus::APPROVED);
        }

        $policy->setStatus($newStatus);
        $policy->setApprovedAdmin($actionAdmin);

        $this->healthAndSafetyPolicyRepository->save($policy);
    }
}