<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;

use Preventool\Application\OccupationalRisk\GetTaskRiskAssessmentByTaskRiskId\GetTaskRiskAssessmentByTaskRiskIdQuery;
use Preventool\Application\OccupationalRisk\Response\TaskRiskAssessmentResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetTaskRiskAssessmentByTaskRiskIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $taskRiskId
    ): Response
    {
        $this->identityValidator->validate($taskRiskId);

        /**
         * @var $response TaskRiskAssessmentResponse|null
         */
        $response = $this->queryBus->handle(
            new GetTaskRiskAssessmentByTaskRiskIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskRiskId
            )
        );

        return new JsonResponse(
            $response?->toArray(),
            $response !== null ? Response::HTTP_OK : Response::HTTP_NO_CONTENT
        );
    }


}