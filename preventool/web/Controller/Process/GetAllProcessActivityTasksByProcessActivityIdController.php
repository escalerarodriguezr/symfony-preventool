<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\GetAllProcessActivityTasksByProcessActivityId\GetAllProcessActivityTasksByProcessActivityIdQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAllProcessActivityTasksByProcessActivityIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $processActivityId
    ):Response
    {
        $this->identityValidator->validate($processActivityId);

        $response = $this->queryBus->handle(
            new GetAllProcessActivityTasksByProcessActivityIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $processActivityId
            )
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }


}