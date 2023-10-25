<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\DeleteWorkplace;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class DeleteWorkplaceCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        DeleteWorkplaceCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        if(
            $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT &&
            $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ADMIN
        ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $workplaceId = new Uuid($command->workplaceId);

        $workplace = $this->workplaceRepository->findById($workplaceId);
        $workplace->setUpdaterAdmin($actionAdmin);
        $this->workplaceRepository->save($workplace);
        $this->workplaceRepository->delete($workplace);
    }


}