<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Preventool\Application\Admin\UpdateAdminById\UpdateAdminCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\UpdateAdminRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $id,
        UpdateAdminRequest $request
    ): Response
    {

        $this->identityValidator->validate($id);

        $command = new UpdateAdminCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id,
            $request->getName() ?? null,
            $request->getLastName() ?? null,
            $request->getRole() ?? null,
            $request->getEmail() ?? null
        );

        $this->commandBus->dispatch(
            $command
        );


        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}