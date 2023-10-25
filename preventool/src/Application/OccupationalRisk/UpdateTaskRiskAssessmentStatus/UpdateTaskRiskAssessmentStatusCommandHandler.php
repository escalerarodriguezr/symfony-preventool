<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\UpdateTaskRiskAssessmentStatus;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\OccupationalRisk\Model\Value\AssessmentStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskAssessmentRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UpdateTaskRiskAssessmentStatusCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly TaskRiskAssessmentRepository $taskRiskAssessmentRepository,
        private readonly TaskRiskRepository $taskRiskRepository,
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        UpdateTaskRiskAssessmentStatusCommand $command
    ): void
    {

        $actionAdminId = new Uuid($command->actionAdminId);
        $taskRiskId = new Uuid($command->taskRiskId);
        $status = new AssessmentStatus($command->status);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $taskRiskAssessment = $this->taskRiskAssessmentRepository->findByTaskRiskId($taskRiskId);
        $taskRisk = $taskRiskAssessment->getTaskRisk();

        $oldStatus = $taskRiskAssessment->getStatus();
        if( $oldStatus->value === $status->value ){
            return;
        }

        $taskRiskAssessment->setStatus($status);
        $taskRiskAssessment->setUpdaterAdmin($actionAdmin);

        if( $status->value === AssessmentStatus::REVISED ){
            $taskRiskAssessment->setRevisedAdmin($actionAdmin);
            $taskRiskAssessment->setApprovedAdmin(null);
            $taskRisk->setStatus(new TaskRiskStatus(TaskRiskStatus::REVISED_ASSESSMENT));
        }

        if( $status->value === AssessmentStatus::APPROVED ){
            $taskRiskAssessment->setApprovedAdmin($actionAdmin);
            if( $taskRiskAssessment->getRevisedAdmin() === null ){
                $taskRiskAssessment->setRevisedAdmin($actionAdmin);
            }
            $taskRisk->setStatus(new TaskRiskStatus(TaskRiskStatus::APPROVED_ASSESSMENT));
        }

        if( $status->value === AssessmentStatus::DRAFT ){
            $taskRiskAssessment->setRevisedAdmin(null);
            $taskRiskAssessment->setApprovedAdmin(null);
            $taskRisk->setStatus(new TaskRiskStatus(TaskRiskStatus::DRAFT_ASSESSMENT));
        }

        $this->taskRiskAssessmentRepository->save($taskRiskAssessment);
        $this->taskRiskRepository->save($taskRisk);

    }


}