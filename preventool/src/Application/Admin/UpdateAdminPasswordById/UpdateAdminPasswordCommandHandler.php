<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\UpdateAdminPasswordById;

use Preventool\Domain\Admin\Exception\AdminInvalidCurrentPasswordException;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Model\Value\UserPassword;
use Preventool\Domain\User\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateAdminPasswordCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function __invoke(
        UpdateAdminPasswordCommand $command
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

        $user = $this->userRepository->findById(
            new Uuid($admin->getId()->value)
        );

        $currentPassword = new UserPassword($command->currentPassword);

        $this->checkActionAdminCanEditUserPassword(
            $actionAdmin,
            $user,
            $currentPassword
        );

        $password = new UserPassword($command->password);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password->value
        );

        $user->setPassword($hashedPassword);
        $this->userRepository->save($user);

    }

    private function checkActionAdminCanEditUserPassword(
        Admin $actionAdmin,
        User $user,
        UserPassword $currentPassword
    ): void
    {

        if( $actionAdmin->getId()->value == $user->getId()->value ){

            $isValid= $this->passwordHasher->isPasswordValid(
                $user,
                $currentPassword->value
            );

            if(!$isValid){
                throw AdminInvalidCurrentPasswordException::withEmail($user->getEmail());
            }

        }else{

            $actionAdminUser = $this->userRepository->findById(
                $actionAdmin->getId()
            );

            $isValid= $this->passwordHasher->isPasswordValid(
                $actionAdminUser,
                $currentPassword->value
            );

            if(!$isValid){
                throw AdminInvalidCurrentPasswordException::withEmail($actionAdminUser->getEmail());
            }
        }
    }

}