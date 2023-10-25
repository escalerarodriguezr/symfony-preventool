<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\SearchCompany\SearchCompanyQuery;
use Preventool\Application\Company\SearchCompany\SearchCompanyResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\SearchCompanyRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchCompanyController
{

    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchCompanyRequest $searchCompanyRequest,
        QueryConditionRequest $queryCondition

    ): Response
    {

        $query = new SearchCompanyQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $queryCondition->getPageSize(),
            $queryCondition->getCurrentPage(),
            $queryCondition->getOrderBy(),
            $queryCondition->getOrderDirection(),
            $searchCompanyRequest->filterById(),
            $searchCompanyRequest->filterByName()
        );

        /**
         * @var $response SearchCompanyResponse
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