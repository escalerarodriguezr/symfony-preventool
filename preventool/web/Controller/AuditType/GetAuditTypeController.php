<?php
declare(strict_types=1);

namespace App\Controller\AuditType;

use Preventool\Application\AuditType\GetAuditTypeById\GetAuditTypeByIdQuery;
use Preventool\Application\AuditType\Response\AuditTypeResponse;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAuditTypeController
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

        $query = new GetAuditTypeByIdQuery(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id
        );

        /**
         * @var AuditTypeResponse $response
         */
        $response = $this->queryBus->handle($query);



        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }


}