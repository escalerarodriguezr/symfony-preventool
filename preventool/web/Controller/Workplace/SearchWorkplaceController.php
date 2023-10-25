<?php
declare(strict_types=1);

namespace App\Controller\Workplace;

use Preventool\Application\Workplace\SearchWorkplace\SearchWorkplaceQuery;
use Preventool\Application\Workplace\SearchWorkplace\SearchWorkplaceResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace\SearchWorkplaceRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchWorkplaceController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchWorkplaceRequest $request,
        QueryConditionRequest $queryCondition

    ): Response
    {

        $query = new SearchWorkplaceQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $queryCondition->getPageSize(),
            $queryCondition->getCurrentPage(),
            $queryCondition->getOrderBy(),
            $queryCondition->getOrderDirection(),
            $request->filterById(),
            $request->getFilterByCompanyId(),
            $request->filterByName()
        );

        /**
         * @var SearchWorkplaceResponse $response
         */
        $response = $this->queryBus->handle(
            $query
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}