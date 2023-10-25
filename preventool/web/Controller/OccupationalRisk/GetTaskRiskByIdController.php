<?php
declare(strict_types=1);

namespace App\Controller\OccupationalRisk;

use Preventool\Application\OccupationalRisk\GetTaskRiskById\GetTaskRiskByIdQuery;
use Preventool\Application\OccupationalRisk\Response\TaskRiskResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Preventool\Infrastructure\Ui\Http\Service\IdentityValidator\HttpIdentityValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetTaskRiskByIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly HttpIdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $id
    ): Response
    {
        $this->identityValidator->validate($id);

        /**
         * @var $response TaskRiskResponse
         */
        $response = $this->queryBus->handle(
            new GetTaskRiskByIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id
            )
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}