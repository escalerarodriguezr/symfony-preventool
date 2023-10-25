<?php
declare(strict_types=1);

namespace App\Controller\Shared\Session;

use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Preventool\Infrastructure\Ui\Http\Service\Session\SessionAdminResponse;
use Preventool\Infrastructure\Ui\Http\Service\Session\SessionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSessionController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService
    )
    {
    }

    public function __invoke(Request $request): Response
    {

        $sessionAdminResponse = new SessionAdminResponse(
            $this->httpRequestService->actionAdmin->getId()->value,
            $this->httpRequestService->actionAdmin->getEmail()->value,
            $this->httpRequestService->actionAdmin->getType()->value,
            $this->httpRequestService->actionAdmin->getRole()->value,
            $this->httpRequestService->actionAdmin->getName()->value,
            $this->httpRequestService->actionAdmin->getLastName()->value
        );

        $sessionResponse = new SessionResponse(
            $this->httpRequestService->actionUserId->value,
            $sessionAdminResponse
        );

        return new JsonResponse(
            $sessionResponse->toArray(),
            Response::HTTP_OK
        );
    }

}