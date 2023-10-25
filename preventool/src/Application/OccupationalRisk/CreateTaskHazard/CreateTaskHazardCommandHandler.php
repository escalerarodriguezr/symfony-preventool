<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\CreateTaskHazard;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardConflictException;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\OccupationalRisk\Repository\TaskHazardRepository;
use Preventool\Domain\OccupationalRisk\Service\CreateTaskRiskService;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardRepository;

class CreateTaskHazardCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly ProcessActivityTaskRepository $taskRepository,
        private readonly WorkplaceHazardRepository $hazardRepository,
        private readonly AdminRepository $adminRepository,
        private readonly TaskHazardRepository $taskHazardRepository,
        private readonly CreateTaskRiskService $createTaskRiskService
    )
    {
    }

    public function __invoke(
        CreateTaskHazardCommand $command
    ): void
    {
        $taskId = new Uuid($command->taskId);
        $hazardId = new Uuid($command->hazardId);
        $actionAdminId = new Uuid($command->actionAdminId);

        $task = $this->taskRepository->findById($taskId);
        $hazard = $this->hazardRepository->findById($hazardId);

        if( $task->getProcessActivity()->getProcess()->getWorkplace()
            ->getId()->value != $hazard->getWorkplace()->getId()->value
        ){
            throw TaskHazardConflictException::taskAndHazardNotBelongToSameWorkplace(
                $taskId,
                $hazardId
            );
        }

        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        $taskHazard = new TaskHazard(
            new Uuid($command->taskHazardId),
            $task,
            $hazard->getWorkplaceHazardCategory()->getName(),
            $hazard->getName(),
            $actionAdmin
        );

        $taskHazard->setHazardDescription($hazard->getDescription());

        $this->taskHazardRepository->save($taskHazard);
        $this->createTaskRiskService->__invoke($taskHazard);
    }


}