<?php
declare(strict_types=1);

namespace App\Controller\WorkplaceHazard;

use Preventool\Application\WorkplaceHazard\SearchWorkplaceHazard\SearchWorkplaceHazardQuery;
use Preventool\Application\WorkplaceHazard\SearchWorkplaceHazard\SearchWorkplaceHazardResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Shared\QueryConditionRequest;
use Preventool\Infrastructure\Ui\Http\Request\DTO\WorkplaceHazard\SearchWorkplaceHazardRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchWorkplaceHazardController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $workplaceId,
        SearchWorkplaceHazardRequest $request,
        QueryConditionRequest $conditionRequest
    ): Response
    {
        $this->identityValidator->validate($workplaceId);
        
        $query = new SearchWorkplaceHazardQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $conditionRequest->getPageSize(),
            $conditionRequest->getCurrentPage(),
            $conditionRequest->getOrderBy(),
            $conditionRequest->getOrderDirection(),
            $request->getFilterById(),
            $workplaceId,
            $request->getFilterByNotHasTaskHazardWithTaskId()
        );


        /**
         * @var $response SearchWorkplaceHazardResponse
         */
        $response = $this->queryBus->handle($query);


        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}