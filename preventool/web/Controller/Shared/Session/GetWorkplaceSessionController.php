<?php
declare(strict_types=1);

namespace App\Controller\Shared\Session;

use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Preventool\Infrastructure\Ui\Http\Service\Session\Workplace\SessionWorkplaceResponse;
use Preventool\Infrastructure\Ui\Http\Service\Session\Workplace\WorkplaceSessionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceSessionController
{

    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        string $id
    ): Response
    {
        $this->identityValidator->validate($id);

        $workplaceId = new Uuid($id);
        $workplace = $this->workplaceRepository->findById($workplaceId);

        $sessionWorkplaceResponse = SessionWorkplaceResponse::createFromWorkplace($workplace);

        $workplaceSessionResponse = new WorkplaceSessionResponse(
            $sessionWorkplaceResponse
        );

        return new JsonResponse(
            $workplaceSessionResponse->toArray(),
            Response::HTTP_OK
        );
    }


}