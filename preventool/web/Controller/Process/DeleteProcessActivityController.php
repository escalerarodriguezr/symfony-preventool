<?php
declare(strict_types=1);

namespace App\Controller\Process;

use Preventool\Application\Process\DeleteProcessActivity\DeleteProcessActivityCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteProcessActivityController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $activityId
    ): Response
    {
        $this->identityValidator->validate($activityId);

        $this->commandBus->dispatch(
            new DeleteProcessActivityCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $activityId
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}