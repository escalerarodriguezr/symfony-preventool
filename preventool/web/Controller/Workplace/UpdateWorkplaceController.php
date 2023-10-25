<?php
declare(strict_types=1);

namespace App\Controller\Workplace;

use Preventool\Application\Workplace\UpdateWorkplace\UpdateWorkplaceCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace\UpdateWorkplaceRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateWorkplaceController
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
        string $id,
        UpdateWorkplaceRequest $request
    ): Response
    {
        $this->identityValidator->validate($companyId);
        $this->identityValidator->validate($id);

        $command = new UpdateWorkplaceCommand(
          $this->httpRequestService->actionAdmin->getId()->value,
          $companyId,
          $id,
          $request->getName(),
          $request->getContactPhone(),
          $request->getAddress(),
          $request->getNumberOfWorkers()
        );

        $this->commandBus->dispatch(
            $command
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );

    }


}