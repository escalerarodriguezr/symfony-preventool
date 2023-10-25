<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\CreateAuditType;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Audit\Exception\AuditTypeAlreadyExistsException;
use Preventool\Domain\Audit\Exception\CreateAuditTypeCommandInvalidCommandException;
use Preventool\Domain\Audit\Model\AuditType;
use Preventool\Domain\Audit\Model\Value\AuditTypeScope;
use Preventool\Domain\Audit\Repository\AuditTypeRepository;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class CreateAuditTypeCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly AuditTypeRepository $auditTypeRepository,
        private readonly IdentityValidator $identityValidator,
        private readonly CompanyRepository $companyRepository,
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        CreateAuditTypeCommand $command
    ): void
    {
        $company = null;
        $workplace = null;

        if( $command->companyId && $command->workplaceId ){
            throw CreateAuditTypeCommandInvalidCommandException::companyAndWorkplaceSuppliedTogether();
        }

        if( $command->companyId ){
            $this->identityValidator->validate(
                $command->companyId
            );
            $companyId = new Uuid($command->companyId);
            $company = $this->companyRepository->findById(
                $companyId
            );
        }

        if( $command->workplaceId ){
            $this->identityValidator->validate(
                $command->workplaceId
            );
            $workplaceId = new Uuid($command->workplaceId);
            $workplace = $this->workplaceRepository->findById(
                $workplaceId
            );
        }

        $auditName = new Name($command->name);
        if(
            !$command->companyId &&
            !$command->workplaceId &&
            $this->auditTypeRepository->findSystemAuditTypeByNameOrNull($auditName)
        ){
            throw AuditTypeAlreadyExistsException::forSystemWithName($auditName);
        }

        $adminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById($adminId);

        $auditTypeId = new Uuid($command->id);

        $auditType = new AuditType(
            $auditTypeId,
            $this->setAuditTypeScope($command),
            $auditName,
        );

        if( $command->description ){
            $auditType->setDescription(
                new MediumDescription(
                    $command->description
                )
            );
        }

        $auditType
            ->setCompany($company)
            ->setWorkplace($workplace)
            ->setCreatorAdmin($actionAdmin);

        $this->auditTypeRepository->save($auditType);

    }

    private function setAuditTypeScope(
        CreateAuditTypeCommand $command
    ): AuditTypeScope
    {
        if( empty($command->companyId) && empty($command->workplaceId) ){
            return new AuditTypeScope(AuditTypeScope::SCOPE_SYSTEM);
        }

        if(empty($command->workplaceId) && !empty($command->companyId)){
            return new AuditTypeScope(AuditTypeScope::SCOPE_COMPANY);
        }

        if(empty($command->companyId) && !empty($command->workplaceId)){
            return new AuditTypeScope(AuditTypeScope::SCOPE_WORKPLACE);
        }

        throw CreateAuditTypeCommandInvalidCommandException::companyAndWorkplaceSuppliedTogether();

    }


}