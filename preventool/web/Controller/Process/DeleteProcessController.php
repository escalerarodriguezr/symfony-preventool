<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\DeleteProcess\DeleteProcessCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteProcessController
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
        string $processId
    ): Response
    {
        $this->identityValidator->validate($workplaceId);
        $this->identityValidator->validate($processId);

        $this->commandBus->dispatch(
            new DeleteProcessCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId,
                $processId
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}