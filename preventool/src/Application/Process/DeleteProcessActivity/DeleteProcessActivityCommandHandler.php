<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteProcessActivity;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class DeleteProcessActivityCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        DeleteProcessActivityCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $activityId = new Uuid($command->activityId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $activity = $this->processActivityRepository->findById($activityId);
        $activity->setUpdaterAdmin($actionAdmin);
        $this->processActivityRepository->save($activity);
        $this->processActivityRepository->delete($activity);

    }


}