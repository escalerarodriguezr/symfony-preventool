<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\ReorderProcessActivities\ReorderProcessActivitiesCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\ReorderProcessActivitiesRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReorderProcessActivitiesController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $processId,
        ReorderProcessActivitiesRequest $request
    ): Response
    {
        $this->identityValidator->validate($processId);

        foreach ($request->getOrder() as $uuid){
            $this->identityValidator->validate($uuid);
        }

        $this->commandBus->dispatch(
            new ReorderProcessActivitiesCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $processId,
                $request->getOrder()
            )
        );


        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}