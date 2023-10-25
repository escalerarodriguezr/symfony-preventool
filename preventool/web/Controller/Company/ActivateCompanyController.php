<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\ActivateCompany\ActivateCompanyCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ActivateCompanyController
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
        $this->identityValidator->validate($id);

        $this->commandBus->dispatch(
            new ActivateCompanyCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id
            )
        );

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }


}