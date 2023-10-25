<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;

use Preventool\Application\OccupationalRisk\UpdateTaskRiskAssessmentStatus\UpdateTaskRiskAssessmentStatusCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\UpdateTaskRiskAssessmentStatusRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskRiskAssessmentStatusController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $taskRiskId,
        UpdateTaskRiskAssessmentStatusRequest $request
    ): Response
    {
        $this->identityValidator->validate($taskRiskId);

        $this->commandBus->dispatch(
            new UpdateTaskRiskAssessmentStatusCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskRiskId,
                $request->getStatus()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }
    
}