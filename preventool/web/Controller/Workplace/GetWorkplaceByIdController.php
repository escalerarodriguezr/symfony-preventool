<?php
declare(strict_types=1);

namespace App\Controller\Workplace;


use Preventool\Application\Company\GetCompanyById\GetCompanyByIdQuery;
use Preventool\Application\Workplace\GetWorkplaceOfCompanyById\GetWorkplaceOfCompanyByIdQuery;
use Preventool\Application\Workplace\Response\WorkplaceResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceByIdController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus
    )
    {
    }

    public function __invoke(
        string $companyId,
        string $workplaceId
    ): Response
    {

        $this->identityValidator->validate($companyId);
        $this->identityValidator->validate($workplaceId);

        $query = new GetWorkplaceOfCompanyByIdQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $companyId,
            $workplaceId
        );

        /**
         * @var WorkplaceResponse $response
         */
        $response = $this->queryBus->handle(
            $query
        );


        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}