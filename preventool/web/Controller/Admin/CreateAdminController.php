<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Preventool\Application\Admin\CreateAdmin\CreateAdminCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\CreateAdminRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateAdminController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        CreateAdminRequest $request
    ): Response
    {
        $id = $this->identityGenerator->generateId();
        $this->commandBus->dispatch(
            new CreateAdminCommand(
                $id,
                $request->getName(),
                $request->getLastName(),
                $request->getEmail(),
                $request->getPassword(),
                $request->getRole(),
                $this->httpRequestService->actionAdmin->getId()->value
            )
        );

        return new JsonResponse(
            [
                HttpRequestService::ID => $id
            ],
            Response::HTTP_CREATED
        );
    }


}