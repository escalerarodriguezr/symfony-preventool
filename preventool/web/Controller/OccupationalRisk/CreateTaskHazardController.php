<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;


use Preventool\Application\OccupationalRisk\CreateTaskHazard\CreateTaskHazardCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\CreateTaskHazardRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateTaskHazardController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        CreateTaskHazardRequest $request
    ): Response
    {
        $taskHazardId = $this->identityGenerator->generateId();

        $this->commandBus->dispatch(
            new CreateTaskHazardCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskHazardId,
                $request->getTaskId(),
                $request->getHazardId()
            )
        );

        return new JsonResponse(
            [HttpRequestService::ID => $taskHazardId],
            Response::HTTP_CREATED
        );
    }


}