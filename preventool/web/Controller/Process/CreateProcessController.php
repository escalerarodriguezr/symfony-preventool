<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\CreateProcess\CreateProcessCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\CreateProcessRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProcessController
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
       string $workplaceId,
        CreateProcessRequest $request
    ): Response
    {

        $this->identityValidator->validate($workplaceId);
        $processId = $this->identityGenerator->generateId();

        $this->commandBus->dispatch(
            new CreateProcessCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId,
                $processId,
                $request->getName(),
                $request->getDescription()
            )
        );

        return new JsonResponse(
            [HttpRequestService::ID => $processId],
            Response::HTTP_CREATED
        );
    }


}