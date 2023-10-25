<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\CreateWorkplace;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\BaselineStudy\Service\CreateBaselineStudyComplianceOfWorkplace;
use Preventool\Domain\BaselineStudy\Service\CreateBaselineStudyOfWorkplace;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Phone;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;
use Preventool\Domain\WorkplaceHazard\Service\CreateWorkplaceHazardCategoriesAndHazards;

class CreateWorkPlaceCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository,
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly CreateBaselineStudyOfWorkplace $createBaselineStudyOfWorkplace,
        private readonly CreateBaselineStudyComplianceOfWorkplace $createBaselineStudyComplianceOfWorkplace,
        private readonly CreateWorkplaceHazardCategoriesAndHazards $createWorkplaceHazardCategoriesAndHazards
    )
    {
    }

    public function __invoke(
        CreateWorkplaceCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        $companyId = new Uuid($command->companyId);
        $company = $this->companyRepository->findById(
            $companyId
        );

        $workpalceId = new Uuid($command->id);

        $workplace = new Workplace(
            $workpalceId,
            $company,
            new Name($command->name),
            new Phone($command->contactPhone),
            new Address($command->address),
            $command->numberOfWorkers
        );

        $workplace->setCreatorAdmin(
            $actionAdmin
        );

        $this->workplaceRepository->save(
            $workplace
        );

        $this->createBaselineStudyOfWorkplace->__invoke($workplace);
        $this->createBaselineStudyComplianceOfWorkplace->__invoke($workplace);
        $this->createWorkplaceHazardCategoriesAndHazards->__invoke($workplace);
    }


}