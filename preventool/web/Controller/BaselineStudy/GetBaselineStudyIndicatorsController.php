<?php
declare(strict_types=1);

namespace App\Controller\BaselineStudy;

use Preventool\Application\BaselineStudy\GetBaselineStudyIndicators\GetBaselineStudyIndicatorsQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetBaselineStudyIndicatorsController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(): Response
    {

        $response = $this->queryBus->handle(
            new GetBaselineStudyIndicatorsQuery(
                $this->httpRequestService->actionAdmin->getId()->value
            )
        );
        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }


}