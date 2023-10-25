<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteActivityTask;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class DeleteActivityTaskCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessActivityTaskRepository $taskRepository
    )
    {
    }

    public function __invoke(
        DeleteActivityTaskCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $taskId = new Uuid($command->taskId);
        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        $task = $this->taskRepository->findById($taskId);

        $task->setUpdaterAdmin($actionAdmin);
        $this->taskRepository->save($task);
        $this->taskRepository->delete($task);
    }

}