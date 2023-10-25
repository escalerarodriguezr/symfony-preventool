<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\ActivateWorkplace;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class ActivateWorkplaceCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        ActivateWorkplaceCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $workplaceId = new Uuid($command->workplaceId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        if (
            $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT &&
            $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ADMIN
        ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $workplace = $this->workplaceRepository->findById($workplaceId);

        $isActive = $workplace->isActive();
        $workplace->setActive(!$isActive);
        $workplace->setUpdaterAdmin($actionAdmin);
        $this->workplaceRepository->save($workplace);

    }


}