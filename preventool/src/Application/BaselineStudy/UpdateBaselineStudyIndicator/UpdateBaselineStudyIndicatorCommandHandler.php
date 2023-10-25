<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\UpdateBaselineStudyIndicator;

use Preventool\Application\BaselineStudy\Event\BaselineStudyWasUpdatedEvent;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventBus;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\MediumObservation;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class UpdateBaselineStudyIndicatorCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly BaselineStudyRepository $baselineStudyRepository,
        private readonly DomainEventBus $eventBus
    )
    {
    }

    public function __invoke(
        UpdateBaselineStudyIndicatorCommand $command

    ):void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $workplaceId = new Uuid($command->workplaceId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $workplace = $this->workplaceRepository->findById($workplaceId);

        $baselineStudy = $this->baselineStudyRepository->findByWorkplaceAndIndicator(
            $workplace,
            $command->indicator
        );

        $updated = false;

        if( $command->compliancePercentage ){
            $baselineStudy->setCompliancePercentage(
                new CompliancePercentage($command->compliancePercentage)
            );
            $updated = true;
        }

        if( !empty($command->observations) ){
            $baselineStudy->setObservations(
                new MediumObservation($command->observations)
            );
            $updated = true;
        }

        if(empty($command->observations) && !empty($baselineStudy->getObservations())){
            $baselineStudy->setObservations(null);
        }

        if( $updated === true ){
            $baselineStudy->setUpdaterAdmin($actionAdmin);
        }

        $this->baselineStudyRepository->save($baselineStudy);

        $this->eventBus->dispatch(
            new BaselineStudyWasUpdatedEvent(
                $baselineStudy->getId()->value
            )
        );

    }


}