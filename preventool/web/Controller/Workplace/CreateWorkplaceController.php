<?php
declare(strict_types=1);

namespace App\Controller\Workplace;


use Preventool\Application\Workplace\CreateWorkplace\CreateWorkplaceCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace\CreateWorkplaceRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateWorkplaceController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $companyId,
        CreateWorkplaceRequest $request
    ): Response
    {
        $this->identityValidator->validate($companyId);
        $workplaceId = $this->identityGenerator->generateId();

        $createWorkplaceCommand = new CreateWorkplaceCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $companyId,
            $workplaceId,
            $request->getName(),
            $request->getContactPhone(),
            $request->getAddress(),
            $request->getNumberOfWorkers()
        );

        $this->commandBus->dispatch(
            $createWorkplaceCommand
        );

        return new JsonResponse(
            [
                HttpRequestService::ID => $workplaceId
            ],
            Response::HTTP_CREATED
        );

    }
    
}