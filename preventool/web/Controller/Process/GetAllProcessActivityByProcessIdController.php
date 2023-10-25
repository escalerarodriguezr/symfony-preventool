<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\GetAllProcessActivityByProcessId\GetAllProcessActivityByProcessIdQuery;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAllProcessActivityByProcessIdController
{
    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $processId
    ): Response
    {
        $this->identityValidator->validate($processId);

        /**
         * @var ProcessActivity[] $response
         */
        $response = $this->queryBus->handle(
            new GetAllProcessActivityByProcessIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $processId
            )
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }


}