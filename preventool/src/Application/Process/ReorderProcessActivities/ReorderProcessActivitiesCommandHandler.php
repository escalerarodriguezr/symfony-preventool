<?php
declare(strict_types=1);

namespace Preventool\Application\Process\ReorderProcessActivities;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ReorderProcessActivitiesCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessRepository $processRepository,
        private readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        ReorderProcessActivitiesCommand $command
    ): void
    {
        $processId = new Uuid($command->processId);
        $adminId = new Uuid($command->actionAdminId);

        $actionAdmin =$this->adminRepository->findById($adminId);
        $process = $this->processRepository->findById($processId);

        $orderMap = [];
        foreach ($command->order as $key => $uuid) {
            $orderMap[$uuid] = $key+1;
        }

        $activities = $process->getProcessActivities();

        foreach ($activities as $activity){
            $uuid = $activity->getId()->value;
            $activity->setActivityOrder($orderMap[$uuid]);
            $activity->setUpdaterAdmin($actionAdmin);
            $this->processActivityRepository->save($activity);
        }

    }


}