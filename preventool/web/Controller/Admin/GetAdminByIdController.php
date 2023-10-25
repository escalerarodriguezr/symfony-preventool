<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Preventool\Application\Admin\GetAdminById\GetAdminByIdQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAdminByIdController
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

        $adminResponse = $this->queryBus->handle(
            new GetAdminByIdQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id
            )
        );

        return new JsonResponse(
            $adminResponse->toArray(),
            Response::HTTP_OK
        );
    }

}