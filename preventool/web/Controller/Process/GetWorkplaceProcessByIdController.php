<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\GetWorkplaceProcessById\GetWorkplaceProcessByIdQuery;
use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceProcessByIdController
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
        string $processId
    ): Response
    {
        $this->identityValidator->validate($workplaceId);
        $this->identityValidator->validate($processId);

        /**
         * @var ProcessResponse $response
         */
        $response = $this->queryBus->handle(
            new GetWorkplaceProcessByIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId,
                $processId
            )
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}