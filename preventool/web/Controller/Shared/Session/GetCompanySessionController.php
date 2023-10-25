<?php
declare(strict_types=1);

namespace App\Controller\Shared\Session;

use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Preventool\Infrastructure\Ui\Http\Service\Session\Company\CompanySessionResponse;
use Preventool\Infrastructure\Ui\Http\Service\Session\Company\SessionCompanyResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetCompanySessionController
{

    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function __invoke(
        string $id
    ): Response
    {
        $this->identityValidator->validate($id);

        $actionCompany = $this->companyRepository->findById(
            new Uuid($id)
        );

        $sessionCompanyResponse = SessionCompanyResponse::createFromCompany(
            $actionCompany
        );

        $companySessionResponse = new CompanySessionResponse(
            $sessionCompanyResponse
        );

        return new JsonResponse(
           $companySessionResponse->toArray(),
            Response::HTTP_OK
        );
    }


}