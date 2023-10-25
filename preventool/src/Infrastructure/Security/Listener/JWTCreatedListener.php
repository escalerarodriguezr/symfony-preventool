<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Security\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Exception\UserAccountNotActiveException;
use Preventool\Domain\User\Model\User;

class JWTCreatedListener
{
    const USER_ID = 'userId';
    const USER_ROLE = 'userRole';
    const USER_EMAIL = 'userEmail';

    public function __construct(
        private readonly AdminRepository $adminRepository
    )
    {
    }


    public function onJWTCreated(JWTCreatedEvent $event): void
    {

        /**
         * @var User $user
         */
        $user = $event->getUser();


        $admin = $this->adminRepository->findById(
            new Uuid($user->getId()->value)
        );

        if(!$admin->isActive() ){
            throw UserAccountNotActiveException::fromLoginService($user->getEmail()->value);
        }


        $payload = $event->getData();
        unset($payload['roles']);
//        unset($payload['username']);
        $payload[self::USER_ID] = $user->getId()->value;
        $payload[self::USER_EMAIL] = $user->getEmail()->value;
        $payload[self::USER_ROLE] = $user->getRole()->value;
        $event->setData($payload);
    }

}