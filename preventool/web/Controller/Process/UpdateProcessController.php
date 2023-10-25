<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\UpdateProcess\UpdateProcessCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\UpdateProcessRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateProcessController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $workplaceId,
        string $processId,
        UpdateProcessRequest $request
    ): Response
    {
        $this->identityValidator->validate($workplaceId);
        $this->identityValidator->validate($processId);

        $command = new UpdateProcessCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $workplaceId,
            $processId,
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