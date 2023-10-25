<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteProcess;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class DeleteProcessCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        DeleteProcessCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $processId = new Uuid($command->processId);
        $actionAdmin = $this->adminRepository->findById($actionAdminId);
        $process = $this->processRepository->findById($processId);
        $process->setUpdaterAdmin($actionAdmin);
        $this->processRepository->save($process);
        $this->processRepository->delete($process);
    }


}