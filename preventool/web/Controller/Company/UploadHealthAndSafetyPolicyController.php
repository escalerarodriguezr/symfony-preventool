<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\UploadHealthAndSafetyPolicy\UploadHealthAndSafetyPolicyCommand;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Service\FileStorageManager\FileStorageManager;
use Preventool\Infrastructure\FileStorage\DigitalOceanFileStorageManager;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\UploadHealthAndSafetyPolicyRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UploadHealthAndSafetyPolicyController
{


    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly FileStorageManager $digitalOceanFileStorageManager,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(
        string $id,
        UploadHealthAndSafetyPolicyRequest $request
    ): Response
    {
        $this->identityValidator->validate($id);

        $resource = $this->digitalOceanFileStorageManager->uploadFile(
            $request->getPolicy(),
            sprintf(DigitalOceanFileStorageManager::COMPANY_HEALTH_SAFTEY_POLICY,$id),
            FileStorageManager::VISIBILITY_PRIVATE
        );

        $command = new UploadHealthAndSafetyPolicyCommand(
            $this->httpRequestService->actionAdmin->getId()->value,
            $id,
            $resource
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