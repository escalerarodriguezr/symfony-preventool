<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\GetAdminById;

use Preventool\Application\Admin\Response\AdminResponse;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetAdminByIdHandler implements QueryHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository
    )
    {
    }

    public function __invoke(
        GetAdminByIdQuery $query
    ): AdminResponse
    {

        $actionAdminId = new Uuid($query->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        if (
            $actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT &&
            $actionAdmin->getId()->value != $query->id
        ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }

        $uuid = new Uuid($query->id);
        $admin = $this->adminRepository->findById(
            $uuid
        );

        return new AdminResponse(
            $admin->getId()->value,
            $admin->getName()->value,
            $admin->getLastName()->value,
            $admin->getEmail()->value,
            $admin->getType()->value,
            $admin->getRole()->value,
            $admin->isActive(),
            $admin->getCreatorAdmin() ? $admin->getCreatorAdmin()->getId()->value : null,
            $admin->getUpdaterAdmin() ? $admin->getUpdaterAdmin()->getId()->value : null,
            $admin->getCreatedAt(),
            $admin->getUpdatedAt()
        );
    }

}