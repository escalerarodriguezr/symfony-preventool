<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateProcess;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\Value\ProcessDescription;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class CreateProcessCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        CreateProcessCommand $command
    ): void
    {


       $actionAdminId = new Uuid($command->actionAdminId);
       $workplaceId = new Uuid($command->workplaceId);
       $processId = new Uuid($command->processId);

       $actionAdmin = $this->adminRepository->findById($actionAdminId);
       $workplace = $this->workplaceRepository->findById($workplaceId);
       
        $process = new Process(
           $processId,
           $workplace,
           new LongName($command->name),
           $actionAdmin
        );

        if($command->description != null){
            $description = new ProcessDescription($command->description);
            $process->setDescription($description);
        }

        $this->processRepository->save($process);
    }

}