<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\SearchProcessActivity\SearchProcessActivityQuery;
use Preventool\Application\Process\SearchProcessActivity\SearchProcessActivityResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\SearchProcessActivityRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchProcessActivityController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchProcessActivityRequest $request,
        QueryConditionRequest $queryConditionRequest

    ): Response
    {

        $query = new SearchProcessActivityQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $queryConditionRequest->getPageSize(),
            $queryConditionRequest->getCurrentPage(),
            $queryConditionRequest->getOrderBy(),
            $queryConditionRequest->getOrderDirection(),
            $request->filterById,
            $request->filterByProcessId
        );

        /**
         * @var SearchProcessActivityResponse $response
         */
        $response = $this->queryBus->handle($query);

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );

    }


}