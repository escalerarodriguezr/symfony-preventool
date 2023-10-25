<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Preventool\Application\Admin\SearchAdmin\SearchAdminQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\SearchAdminRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchAdminController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchAdminRequest $request,
        QueryConditionRequest $queryCondition

    ): Response
    {
        $query = new SearchAdminQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $queryCondition->getPageSize(),
            $queryCondition->getCurrentPage(),
            $queryCondition->getOrderBy(),
            $queryCondition->getOrderDirection(),
            $request->filterById(),
            $request->filterByEmail(),
            $request->filterByCreatedAtFrom(),
            $request->filterByCreatedAtTo()
        );

        $response = $this->queryBus->handle(
            $query
        );
        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}