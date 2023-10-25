<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\DeleteTaskHazardById;

use Preventool\Domain\OccupationalRisk\Repository\TaskHazardRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskAssessmentRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class DeleteTaskHazardByIdCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly TaskHazardRepository $taskHazardRepository,
        private readonly TaskRiskRepository $taskRiskRepository,
        private readonly TaskRiskAssessmentRepository $taskRiskAssessmentRepository
    )
    {
    }

    public function __invoke(
        DeleteTaskHazardByIdCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $taskHazardId = new Uuid($command->taskHazardId);

        $taskHazard = $this->taskHazardRepository->findById($taskHazardId);
        $taskRisk = $taskHazard->getTaskRisk();
        $taskRiskAssessment = $taskRisk?->getTaskRiskAssessment();

        $this->taskHazardRepository->delete($taskHazard);
        if($taskRisk !== null){
            $this->taskRiskRepository->delete($taskRisk);
        }
        if($taskRiskAssessment !== null){
            $this->taskRiskAssessmentRepository->delete($taskRiskAssessment);
        }
    }

}