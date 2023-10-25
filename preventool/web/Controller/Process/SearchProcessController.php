<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\SearchProcess\SearchProcessQuery;
use Preventool\Application\Process\SearchProcess\SearchProcessResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\SearchProcessRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchProcessController
{

    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchProcessRequest $searchProcessRequest,
        QueryConditionRequest $queryConditionRequest

    ): Response
    {
        $query = new SearchProcessQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $queryConditionRequest->getPageSize(),
            $queryConditionRequest->getCurrentPage(),
            $queryConditionRequest->getOrderBy(),
            $queryConditionRequest->getOrderDirection(),
            $searchProcessRequest->filterById,
            $searchProcessRequest->filterByName,
            $searchProcessRequest->filterByWorkplaceId
        );

        /**
         * @var SearchProcessResponse $response
         */
        $response = $this->queryBus->handle($query);

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}