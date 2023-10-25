<?php
declare(strict_types=1);

namespace App\Controller\BaselineStudy;

use Preventool\Application\BaselineStudy\GetBaselineStudyComplianceByWorkplaceId\GetBaselineStudyComplianceByWorkplaceIdQuery;
use Preventool\Application\BaselineStudy\Response\BaselineStudyComplianceResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetBaselineStudyComplianceByWorkplaceIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $workplaceId
    ): Response
    {
        $this->identityValidator->validate($workplaceId);

        /**
         * @var BaselineStudyComplianceResponse $response
         */
        $response = $this->queryBus->handle(
            new GetBaselineStudyComplianceByWorkplaceIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId
            )
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}