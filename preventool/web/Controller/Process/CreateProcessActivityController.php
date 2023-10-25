<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\CreateProcessActivity\CreateProcessActivityCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\CreateProcessActivityRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProcessActivityController
{
    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $processId,
        CreateProcessActivityRequest $request
    ): Response
    {
        $this->identityValidator->validate($processId);
        $activityId = $this->identityGenerator->generateId();

        $this->commandBus->dispatch(
            new CreateProcessActivityCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $processId,
                $activityId,
                $request->getName(),
                $request->getDescription()
            )
        );

        return new JsonResponse(
            [HttpRequestService::ID => $activityId],
            Response::HTTP_CREATED
        );
    }

}