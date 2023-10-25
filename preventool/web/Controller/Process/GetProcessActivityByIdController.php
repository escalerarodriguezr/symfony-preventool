<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\GetProcessActivityById\GetProcessActivityByIdQuery;
use Preventool\Application\Process\Response\ProcessActivityResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetProcessActivityByIdController
{


    public function __construct(
        private readonly IdentityValidator $identityValidator,
        private readonly HttpRequestService $httpRequestService,
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
         * @var ProcessActivityResponse $response
         */
        $response = $this->queryBus->handle(
            new GetProcessActivityByIdQuery(
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