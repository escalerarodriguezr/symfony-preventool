<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\CalculateTaskRiskAssessment;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\OccupationalRisk\Model\TaskRiskAssessment;
use Preventool\Domain\OccupationalRisk\Model\Value\AssessmentStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\ExposureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\PeopleExposedIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\ProcedureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\SeverityIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\TrainingIndex;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskAssessmentRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CalculateTaskRiskAssessmentCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly TaskRiskRepository $taskRiskRepository,
        private readonly TaskRiskAssessmentRepository $taskRiskAssessmentRepository
    )
    {
    }

    public function __invoke(CalculateTaskRiskAssessmentCommand $command): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $taskRiskId = new Uuid($command->taskRiskId);
        $taskRiskAssessmentId = new Uuid($command->taskRiskAssessmentId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $taskRisk = $this->taskRiskRepository->findById($taskRiskId);

        $taskRiskAssessment = $taskRisk->getTaskRiskAssessment();
        if( $taskRiskAssessment === null ){
            $taskRiskAssessment = new TaskRiskAssessment(
                $taskRiskAssessmentId,
                $taskRisk,
                new AssessmentStatus(AssessmentStatus::DRAFT),
                0,
                new SeverityIndex($command->severityIndex),
                new PeopleExposedIndex($command->peopleExposedIndex),
                new ProcedureIndex($command->procedureIndex),
                new TrainingIndex($command->trainingIndex),
                new ExposureIndex($command->exposureIndex),
                $actionAdmin
            );
        }else{
            $taskRiskAssessment->setSeverityIndex(
                new SeverityIndex($command->severityIndex)
            );
            $taskRiskAssessment->setPeopleExposedIndex(
                new PeopleExposedIndex($command->peopleExposedIndex)
            );
            $taskRiskAssessment->setProcedureIndex(
                new ProcedureIndex($command->procedureIndex)
            );
            $taskRiskAssessment->setTrainingIndex(
                new TrainingIndex($command->trainingIndex)
            );
            $taskRiskAssessment->setExposureIndex(
                new ExposureIndex($command->exposureIndex)
            );
            $taskRiskAssessment->setUpdaterAdmin($actionAdmin);
        }

        $taskRisk->setStatus(
            new TaskRiskStatus(TaskRiskStatus::DRAFT_ASSESSMENT)
        );

        $this->taskRiskAssessmentRepository->save($taskRiskAssessment);
        $this->taskRiskRepository->save($taskRisk);
    }


}