<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\CreateActivityTask\CreateActivityTaskCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\CreateActivityTaskRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateActivityTaskController
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
        string $activityId,
        CreateActivityTaskRequest $request
    ): Response
    {
        $this->identityValidator->validate($activityId);
        $taskId = $this->identityGenerator->generateId();

        $this->commandBus->dispatch(
            new CreateActivityTaskCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $activityId,
                $taskId,
                $request->getName(),
                $request->getDescription()
            )
        );

        return new JsonResponse(
            [HttpRequestService::ID => $taskId],
            Response::HTTP_CREATED
        );

    }


}