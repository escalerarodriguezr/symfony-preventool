<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\UpdateAdminById;

use Preventool\Domain\Admin\Exception\AdminAlreadyExistsException;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\LastName;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Repository\UserRepository;

class UpdateAdminCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function __invoke(
        UpdateAdminCommand $command
    ): void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        $adminId = new Uuid($command->id);
        $admin = $this->adminRepository->findById(
            $adminId
        );

        if( ($actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT)
            && ($actionAdminId->value != $command->id)
        ){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }


        if( !empty($command->name) ){
            $admin->setName(
                new Name($command->name)
            );
        }

        if(!empty($command->lastName)){
            $admin->setLastName(
                new LastName($command->lastName)
            );
        }

        if(!empty($command->role) &&
            $actionAdmin->getRole()->value === AdminRole::ADMIN_ROLE_ROOT
        ){
            $admin->setRole(
                new AdminRole(
                    $command->role
                )
            );
        }

        if(!empty($command->email)){

            $email =new Email(
                $command->email
            );

            $registeredAdmin = $this->adminRepository->findByEmailOrNull(
                $email
            );

            if($registeredAdmin &&
                ($registeredAdmin->getId()->value != $admin->getId()->value)
            ){
                throw AdminAlreadyExistsException::withEmail($email);
            }

            $admin->setEmail(
                $email
            );

            $user = $this->userRepository->findById(
                new Uuid($admin->getId()->value)
            );

            $user->setEmail(
                $email
            );

            $this->userRepository->save(
                $user
            );

        }

        $admin->setUpdaterAdmin(
            $actionAdmin
        );

        $this->adminRepository->save(
            $admin
        );
    }


}