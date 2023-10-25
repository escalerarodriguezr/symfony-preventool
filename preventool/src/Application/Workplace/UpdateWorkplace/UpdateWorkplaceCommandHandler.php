<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\UpdateWorkplace;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Phone;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Exception\WorkplaceNotBelongToCompanyException;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class UpdateWorkplaceCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        UpdateWorkplaceCommand $updateWorkplaceCommand
    ): void
    {
        $actionAdminId = new Uuid($updateWorkplaceCommand->actionAdminId);

        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        $workplaceId = new Uuid($updateWorkplaceCommand->id);

        $workplace = $this->workplaceRepository->findById(
            $workplaceId
        );

        $companyId = new Uuid($updateWorkplaceCommand->companyId);
        if( $workplace->getCompany()->getId()->value != $updateWorkplaceCommand->companyId ){
            throw WorkplaceNotBelongToCompanyException::withWokplaceIdAndCompanyId(
                $companyId,
                $workplaceId
            );
        }

        if( !empty($updateWorkplaceCommand->name) ){
            $workplace->setName(new Name($updateWorkplaceCommand->name));
        }

        if(!empty($updateWorkplaceCommand->contactPhone)){
            $workplace->setContactPhone(new Phone($updateWorkplaceCommand->contactPhone));
        }

        if(!empty($updateWorkplaceCommand->address)){
            $workplace->setAddress(new Address($updateWorkplaceCommand->address));
        }

        if(!empty($updateWorkplaceCommand->numberOfWorkers)){
            $workplace->setNumberOfWorkers($updateWorkplaceCommand->numberOfWorkers);
        }

        $workplace->setUpdaterAdmin(
            $actionAdmin
        );

        $this->workplaceRepository->save(
            $workplace
        );
    }


}