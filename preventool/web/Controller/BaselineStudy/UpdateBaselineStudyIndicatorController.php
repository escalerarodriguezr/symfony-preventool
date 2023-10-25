<?php
declare(strict_types=1);

namespace App\Controller\BaselineStudy;

use Preventool\Application\BaselineStudy\UpdateBaselineStudyIndicator\UpdateBaselineStudyIndicatorCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\BaselineStudy\UpdateBaselineStudyIndicatorRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateBaselineStudyIndicatorController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $workplaceId,
        string $indicator,
        UpdateBaselineStudyIndicatorRequest $request
    ): Response
    {
        $this->identityValidator->validate($workplaceId);

        $this->commandBus->dispatch(
            new UpdateBaselineStudyIndicatorCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $workplaceId,
                $indicator,
                $request->getCompliancePercentage(),
                $request->getObservations()
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}