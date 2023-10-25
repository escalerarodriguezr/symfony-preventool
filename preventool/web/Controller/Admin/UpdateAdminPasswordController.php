<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Preventool\Application\Admin\UpdateAdminPasswordById\UpdateAdminPasswordCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\UpdateAdminPasswordRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminPasswordController
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
        UpdateAdminPasswordRequest $request
    ): Response
    {
        $this->identityValidator->validate($id);

        $updateAdminPassword = new UpdateAdminPasswordCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id,
            $request->getCurrentPassword(),
            $request->getPassword()
        );

        $this->commandBus->dispatch(
            $updateAdminPassword
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );

    }

}