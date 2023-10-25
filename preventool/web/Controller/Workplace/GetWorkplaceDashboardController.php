<?php
declare(strict_types=1);

namespace App\Controller\Workplace;

use Preventool\Application\Workplace\GetWorkplaceDashboard\GetWorkplaceDashboardQuery;
use Preventool\Application\Workplace\GetWorkplaceDashboard\Response\WorkplaceDashboardResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceDashboardController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $id
    ): Response
    {
        $this->identityValidator->validate($id);

        /**
         * @var WorkplaceDashboardResponse $response
         */
        $response = $this->queryBus->handle(
            new GetWorkplaceDashboardQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id
            )
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}