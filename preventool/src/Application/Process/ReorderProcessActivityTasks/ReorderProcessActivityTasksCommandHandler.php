<?php
declare(strict_types=1);

namespace Preventool\Application\Process\ReorderProcessActivityTasks;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ReorderProcessActivityTasksCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly ProcessActivityRepository $processActivityRepository,
        private readonly ProcessActivityTaskRepository $processActivityTaskRepository,
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        ReorderProcessActivityTasksCommand $command
    ):void
    {
       $processActivityId = new Uuid($command->processActivityId);
       $actionAdminId = new Uuid($command->actionAdminId);

       $actionAdmin = $this->adminRepository->findById($actionAdminId);
       $processActivity = $this->processActivityRepository->findById($processActivityId);

        $orderMap = [];
        foreach ($command->order as $key => $uuid) {
            $orderMap[$uuid] = $key+1;
        }

        $tasks = $processActivity->getActivityTasks();

        /**
         * @var $task ProcessActivityTask
         */
        foreach ($tasks as $task){
            $uuid = $task->getId()->value;
            $task->setUpdaterAdmin($actionAdmin);
            $task->setTaskOrder($orderMap[$uuid]);
            $this->processActivityTaskRepository->save($task);
        }

    }


}