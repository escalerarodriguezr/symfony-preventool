<?php
declare(strict_types=1);

namespace Preventool\Application\Process\UpdateProcessActivityTask;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\Value\ActivityTaskDescription;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UpdateProcessActivityTaskCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly ProcessActivityTaskRepository $processActivityTaskRepository,
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        UpdateProcessActivityTaskCommand $command
    ):void
    {
        $adminId = new Uuid($command->actionAdminId);
        $taskId = new Uuid($command->taskId);

        $actionAdmin = $this->adminRepository->findById($adminId);
        $task = $this->processActivityTaskRepository->findById($taskId);

        if($command->name !== null){
            $task->setName(
                new LongName($command->name)
            );
        }

        if($command->description !== null){
            $task->setDescription(
                new ActivityTaskDescription($command->description)
            );
        }else{
            $task->setDescription(null);
        }

        $task->setUpdaterAdmin($actionAdmin);

        $this->processActivityTaskRepository->save($task);
    }


}