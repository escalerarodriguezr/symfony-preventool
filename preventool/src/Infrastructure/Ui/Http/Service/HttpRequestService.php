<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Service;

use Preventool\Domain\Admin\Exception\AdminNotFoundException;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\Security\Listener\JWTAuthenticatedListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HttpRequestService
{
    const ID = 'uuid';
    public readonly Uuid $actionUserId;
    public readonly Admin $actionAdmin;




    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly AdminRepository $adminRepository
    )
    {
        $this->actionUserId = new Uuid(
            $this->requestStack->getCurrentRequest()->get(
                JWTAuthenticatedListener::ACTION_USER_ID
            )
        );
        $this->setActionAdmin();
    }

    private function setActionAdmin() : void
    {
        try{
            $this->actionAdmin = $this->adminRepository->findById($this->actionUserId);
        }catch (AdminNotFoundException $exception){
            throw new AccessDeniedException();
        }
    }
}