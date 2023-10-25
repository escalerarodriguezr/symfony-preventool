<?php
declare(strict_types=1);

namespace App\Controller\AuditType;

use Preventool\Application\AuditType\CreateAuditType\CreateAuditTypeCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\AuditType\CreateAuditTypeRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateAuditTypeController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        CreateAuditTypeRequest $request
    ): Response
    {

        $auditTypeId = $this->identityGenerator->generateId();

        $command = new CreateAuditTypeCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $auditTypeId,
            $request->getName(),
            $request->getDescription(),
            $request->getCompanyId(),
            $request->getWorkplaceId()
        );

        $this->commandBus->dispatch(
            $command
        );

        return new JsonResponse(
            [
                HttpRequestService::ID => $auditTypeId
            ],
            Response::HTTP_CREATED
        );
    }


}