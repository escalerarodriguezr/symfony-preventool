<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\DeleteActivityTask\DeleteActivityTaskCommand;
use Preventool\Application\Process\DeleteActivityTask\DeleteActivityTaskCommandHandler;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteActivityTaskController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $taskId
    ): Response
    {
        $this->identityValidator->validate($taskId);

        $this->commandBus->dispatch(
            new DeleteActivityTaskCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskId
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}