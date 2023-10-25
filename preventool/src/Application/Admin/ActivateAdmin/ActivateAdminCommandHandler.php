<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\ActivateAdmin;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;


class ActivateAdminCommandHandler implements CommandHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        ActivateAdminCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $adminId = new Uuid($command->adminId);

        $actionAdmin = $this->adminRepository->findById($actionAdminId);

        if ($actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $admin = $this->adminRepository->findById($adminId);
        $isActive = $admin->isActive();
        $admin->setActive(!$isActive);
        $admin->setUpdaterAdmin($actionAdmin);
        $this->adminRepository->save($admin);
    }


}