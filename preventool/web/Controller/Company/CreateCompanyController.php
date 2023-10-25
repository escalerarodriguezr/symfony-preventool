<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\CreateCompany\CreateCompanyCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\CreateCompanyRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCompanyController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityGenerator $identityGenerator,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        CreateCompanyRequest $request

    ): Response
    {
        $companyId = $this->identityGenerator->generateId();
        $this->commandBus->dispatch(
            new CreateCompanyCommand(
                $this->httpRequestService->actionAdmin->getId()->value,
                $companyId,
                $request->getName(),
                $request->getLegalName(),
                $request->getLegalDocument(),
                $request->getAddress(),
                $request->getSector()
            )
        );

        return new JsonResponse(
            [
                HttpRequestService::ID => $companyId
            ],
            Response::HTTP_CREATED
        );
    }


}