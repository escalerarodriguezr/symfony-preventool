<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\UpdateProcessActivity\UpdateProcessActivityCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\UpdateProcessActivityRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateProcessActivityByIdController
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
        UpdateProcessActivityRequest $request
    ): Response
    {
        $this->identityValidator->validate($id);

        $command = new UpdateProcessActivityCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id,
            $request->getName(),
            $request->getDescription()
        );

        $this->commandBus->dispatch($command);

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}