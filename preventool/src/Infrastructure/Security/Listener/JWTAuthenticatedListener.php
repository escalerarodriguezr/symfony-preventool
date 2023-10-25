<?php

namespace Preventool\Infrastructure\Security\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Exception\UserAccountNotActiveException;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTAuthenticatedListener
{
    const ACTION_USER_ID = 'actionUserId';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly AdminRepository $adminRepository

    )
    {
    }

    public function onJWTAuthenticated(JWTAuthenticatedEvent $event)
    {

        $userId = new Uuid($event->getPayload()[JWTCreatedListener::USER_ID]);

        $admin = $this->adminRepository->findById($userId);
        if(!$admin->isActive() ){
            throw UserAccountNotActiveException::fromSecurity($userId->value);
        }

        $this->addRequestParams($userId);

    }

    private function addRequestParams(Uuid $actionUserId): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $request->attributes->set(self::ACTION_USER_ID, $actionUserId->value);

    }

}