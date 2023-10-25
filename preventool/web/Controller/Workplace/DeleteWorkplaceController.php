<?php
declare(strict_types=1);

namespace App\Controller\Workplace;

use Preventool\Application\Workplace\DeleteWorkplace\DeleteWorkplaceCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteWorkplaceController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
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

        $this->commandBus->dispatch(
            new DeleteWorkplaceCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $companyId,
                $workplaceId
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}