<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;

use Preventool\Application\OccupationalRisk\UpdateTaskRisk\UpdateTaskRiskCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\UpdateTaskRiskRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskRiskController
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
        UpdateTaskRiskRequest $request
    ): Response
    {
        $this->identityValidator->validate($id);
        $this->commandBus->dispatch(
            new UpdateTaskRiskCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id,
                $request->getName(),
                $request->getObservations(),
                $request->getLegalRequirement(),
                $request->getHazardName(),
                $request->getHazardDescription()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}