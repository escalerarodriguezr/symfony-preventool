<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateActivityTask;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Process\Model\Value\ActivityTaskDescription;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CreateActivityTaskCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessActivityRepository $processActivityRepository,
        private readonly ProcessActivityTaskRepository $processActivityTaskRepository
    )
    {
    }

    public function __invoke(
        CreateActivityTaskCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $activityId = new Uuid($command->activityId);
        $taskId = new Uuid($command->taskId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $activity = $this->processActivityRepository->findById($activityId);
        $taskOrder = $activity->getActivityTasks()->count() + 1;

        $task = new ProcessActivityTask(
            $taskId,
            $activity,
            new LongName($command->name),
            $taskOrder
        );

        if($command->description !== null){
            $task->setDescription(
                new ActivityTaskDescription($command->description)
            );
        }

        $task->setCreatorAdmin($actionAdmin);

        $this->processActivityTaskRepository->save($task);


    }


}