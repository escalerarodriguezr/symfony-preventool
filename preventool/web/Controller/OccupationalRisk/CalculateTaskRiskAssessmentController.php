<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;

use Preventool\Application\OccupationalRisk\CalculateTaskRiskAssessment\CalculateTaskRiskAssessmentCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\CalculateTaskRiskAssessmentRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CalculateTaskRiskAssessmentController
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
        string $taskRiskId,
        CalculateTaskRiskAssessmentRequest $request
    ): Response
    {
        $this->identityValidator->validate($taskRiskId);
        $id = $this->identityGenerator->generateId();

        $this->commandBus->dispatch(
            new CalculateTaskRiskAssessmentCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskRiskId,
                $id,
                $request->getSeverityIndex(),
                $request->getPeopleExposedIndex(),
                $request->getProcedureIndex(),
                $request->getTrainingIndex(),
                $request->getExposureIndex()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}