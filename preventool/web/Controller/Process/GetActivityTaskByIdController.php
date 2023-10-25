<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\GetActivityTaskById\GetActivityTaskByIdQuery;
use Preventool\Application\Process\Response\ProcessActivityTaskResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetActivityTaskByIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $taskId
    ):Response
    {
        $this->identityValidator->validate($taskId);

        /**
         * @var $response ProcessActivityTaskResponse
         */
        $response = $this->queryBus->handle(
            new GetActivityTaskByIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $taskId
            )
        );

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}