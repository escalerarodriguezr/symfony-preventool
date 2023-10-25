<?php
declare(strict_types=1);

namespace App\Controller\BaselineStudy;

use Preventool\Application\BaselineStudy\GetWorkplaceBaselineStudyIndicatorsByCategory\GetWorkplaceBaselineStudyIndicatorsByCategoryQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceBaselineStudyIndicatorsByCategoryController
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
        string $category
    ): Response
    {

        $this->identityValidator->validate($workplaceId);

        $response = $this->queryBus->handle(
            new GetWorkplaceBaselineStudyIndicatorsByCategoryQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId,
                $category
            )
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }


}