<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\ApproveHealthAndSafetyPolicy\ApproveHealthAndSafetyPolicyCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PutApproveHealthAndSafetyPolicyController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $id
    ): Response
    {
        $this->identityValidator->validate(
            $id
        );

        $command = new ApproveHealthAndSafetyPolicyCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id
        );

        $this->commandBus->dispatch($command);

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}