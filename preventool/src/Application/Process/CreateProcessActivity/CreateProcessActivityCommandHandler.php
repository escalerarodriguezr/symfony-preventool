<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateProcessActivity;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Process\Model\Value\ProcessActivityDescription;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CreateProcessActivityCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessRepository $processRepository,
        private readonly ProcessActivityRepository $processActivityRepository

    )
    {
    }

    public function __invoke(
        CreateProcessActivityCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $processId = new Uuid($command->processId);
        $processActivityId = new Uuid($command->activityId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $process = $this->processRepository->findById($processId);

        $order = $process->getProcessActivities()->count() + 1;

        $processActivity = new ProcessActivity(
            $processActivityId,
            $process,
            new LongName($command->name),
            $order
        );

        if($command->description != null){
            $processActivity->setDescription(
                new ProcessActivityDescription($command->description)
            );
        }

        $processActivity->setCreatorAdmin($actionAdmin);

        $this->processActivityRepository->save($processActivity);
    }


}