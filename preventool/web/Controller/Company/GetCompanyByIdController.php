<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\GetCompanyById\GetCompanyByIdQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetCompanyByIdController
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

        $query = new GetCompanyByIdQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id
        );

        $companyResponse = $this->queryBus->handle(
            $query
        );

        return new JsonResponse(
            $companyResponse->toArray(),
            Response::HTTP_OK
        );
    }


}