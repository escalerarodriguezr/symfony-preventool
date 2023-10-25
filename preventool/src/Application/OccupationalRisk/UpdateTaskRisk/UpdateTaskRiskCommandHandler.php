<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\UpdateTaskRisk;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\OccupationalRisk\Model\Value\LegalRequirement;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskObservations;
use Preventool\Domain\OccupationalRisk\Repository\TaskHazardRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UpdateTaskRiskCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly TaskRiskRepository $taskRiskRepository,
        private readonly TaskHazardRepository $taskHazardRepository
    )
    {
    }

    public function __invoke(
        UpdateTaskRiskCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $taskRiskId = new Uuid($command->taskRiskId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $taskRisk = $this->taskRiskRepository->findById($taskRiskId);

        $taskHazard = $taskRisk->getTaskHazard();

        if($command->name !== null){
            $taskRisk->setName(
                new LongName($command->name)
            );
        }

        if($command->observations !== null){
            $observations = !empty(trim($command->observations)) ? new TaskRiskObservations($command->observations) : null;
            $taskRisk->setObservations($observations);
        }

        if($command->legalRequirement !== null){
            $legalRequirement = !empty(trim($command->legalRequirement)) ? new LegalRequirement($command->legalRequirement) : null;
            $taskRisk->setLegalRequirement($legalRequirement);
        }


        if($command->hazardName !== null){
            $taskHazard->setHazardName(new Name($command->hazardName));
        }

        if($command->hazardDescription !== null){
            $hazardDescription = !empty(trim($command->hazardDescription)) ? new MediumDescription($command->hazardDescription) : null;
            $taskHazard->setHazardDescription($hazardDescription);
        }

        $taskHazard->setUpdaterAdmin($actionAdmin);
        $taskRisk->setUpdaterAdmin($actionAdmin);

        $this->taskRiskRepository->save($taskRisk);
        $this->taskHazardRepository->save($taskHazard);
    }
    
}