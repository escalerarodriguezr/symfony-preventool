<?php
declare(strict_types=1);

namespace App\Controller\AuditType;

use Preventool\Application\AuditType\SearchAuditType\SearchAuditTypeQuery;
use Preventool\Application\AuditType\SearchAuditType\SearchAuditTypeResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Infrastructure\Ui\Http\Request\DTO\AuditType\SearchAuditTypeRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchAuditTypeController
{
    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        SearchAuditTypeRequest $searchAuditTypeRequest,
        QueryConditionRequest $conditionRequest
    ): Response
    {

        $query = new SearchAuditTypeQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $conditionRequest->getPageSize(),
            $conditionRequest->getCurrentPage(),
            $conditionRequest->getOrderBy(),
            $conditionRequest->getOrderDirection(),
            $searchAuditTypeRequest->filterById,
            $searchAuditTypeRequest->filterByCompanyId,
            $searchAuditTypeRequest->filterByWorkplaceId
        );

        /** @var  $response SearchAuditTypeResponse */
        $response = $this->queryBus->handle($query);

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }

}