<?php
declare(strict_types=1);

namespace Preventool\Application\Process\UpdateProcess;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Process\Exception\ProcessAlreadyExistsException;
use Preventool\Domain\Process\Model\Value\ProcessDescription;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class UpdateProcessCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        UpdateProcessCommand $command
    ): void
    {
        $adminId = new Uuid($command->actionAdminId);
        $processId = new Uuid($command->processId);
        $workplaceId = new Uuid($command->workplaceId);
        $actionAdmin = $this->adminRepository->findById($adminId);

        $workplace = $this->workplaceRepository->findById($workplaceId);
        $process = $this->processRepository->findByWorkplaceAndId($workplace,$processId);

        if(!empty($command->name)){
            $name = new LongName($command->name);
            $processExists =  $this->processRepository->findByWorkplaceAndNameOrNull($workplace,$name);
            if(
                $processExists !== null &&
                $process->getId()->value != $processExists->getId()->value
            ){
                throw ProcessAlreadyExistsException::withNameForWorkplace($name,$workplace);
            }

            $process->setName($name);
        }

        if(!empty($command->description)){
            $description = new ProcessDescription($command->description);
            $process->setDescription($description);
        }

        $process->setUpdaterAdmin($actionAdmin);

        $this->processRepository->save($process);

    }


}