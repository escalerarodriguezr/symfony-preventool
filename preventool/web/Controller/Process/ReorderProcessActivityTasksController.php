<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\ReorderProcessActivityTasks\ReorderProcessActivityTasksCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\ReorderProcessActivitiesRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReorderProcessActivityTasksController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $processActivityId,
        ReorderProcessActivitiesRequest $request
    ): Response
    {
        $this->identityValidator->validate($processActivityId);

        $this->commandBus->dispatch(
            new ReorderProcessActivityTasksCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $processActivityId,
                $request->getOrder()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }
    
}