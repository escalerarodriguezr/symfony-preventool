<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\CreateAdmin;

use Preventool\Application\Admin\Event\AdminCreated\AdminCreatedEvent;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Model\Value\AdminType;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventBus;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\LastName;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Model\Value\UserPassword;
use Preventool\Domain\User\Model\Value\UserRole;
use Preventool\Domain\User\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private AdminRepository $adminRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly DomainEventBus $eventBus
    )
    {
    }

    public function __invoke(
        CreateAdminCommand $command
    ) : void
    {
        $actionAdminId = new Uuid($command->actionAdminId);
        $actionAdmin = $this->adminRepository->findById(
            $actionAdminId
        );

        if ($actionAdmin->getRole()->value != AdminRole::ADMIN_ROLE_ROOT){
            throw ActionNotAllowedException::fromApplicationUseCase($actionAdminId);
        }


        $adminId = new Uuid($command->id);
        $email = new Email($command->email);
        $admin = new Admin(
            $adminId,
            $email,
            new AdminType(AdminType::ADMIN_TYPE_ADMIN),
            new AdminRole($command->role),
            new Name($command->name),
            new LastName($command->lastName)
        );
        $admin->setCreatorAdmin($actionAdmin);

        $this->adminRepository->save($admin);

        $user = new User(
            $adminId,
            $email,
            new UserRole(UserRole::USER_ROLE_ADMIN)
        );
        $password = new UserPassword($command->password);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password->value
        );

        $user->setPassword($hashedPassword);
        $this->userRepository->save($user);

        $this->eventBus->dispatch(
            new AdminCreatedEvent(
                $admin->getId()->value
            )
        );

    }
}