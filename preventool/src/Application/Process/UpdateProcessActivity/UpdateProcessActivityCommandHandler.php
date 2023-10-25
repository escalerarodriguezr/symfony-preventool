<?php
declare(strict_types=1);

namespace Preventool\Application\Process\UpdateProcessActivity;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\Value\ProcessActivityDescription;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UpdateProcessActivityCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        public readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        UpdateProcessActivityCommand $command
    ): void
    {

        $actionAdminId = new Uuid($command->actionAdminId);
        $processActivityId = new Uuid($command->activityId);

        $processActivity = $this->processActivityRepository->findById($processActivityId);
        $actionAdminId = $this->adminRepository->findById($actionAdminId);

        $processActivity->setName(new LongName($command->name));

        $description = !empty($command->description) ? new ProcessActivityDescription($command->description) : null;

        $processActivity->setDescription($description);

        $processActivity->setUpdaterAdmin($actionAdminId);

        $this->processActivityRepository->save($processActivity);

    }


}