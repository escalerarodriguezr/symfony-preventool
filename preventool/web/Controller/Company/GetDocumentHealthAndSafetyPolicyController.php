<?php
declare(strict_types=1);

namespace App\Controller\Company;

use Preventool\Application\Company\GetDocumentHealthAndSafetyPolicy\GetDocumentHealthAndSafetyPolicyQuery;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Service\FileStorageManager\FileStorageManager;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GetDocumentHealthAndSafetyPolicyController
{

    public function __construct(
        private readonly HttpRequestService $httpRequestService,
        private readonly IdentityValidator $identityValidator,
        private readonly QueryBus $queryBus,
        private readonly string $projectDigitalOceanStoragePath,
        private readonly FileStorageManager $digitalOceanFileStorageManager,
    )
    {
    }

    public function __invoke(
        string $id
    ): StreamedResponse
    {
        $this->identityValidator->validate($id);

        $resourcePath = $this->queryBus->handle(
            new GetDocumentHealthAndSafetyPolicyQuery(
                $this->httpRequestService->actionAdmin->getId()->value,
                $id
            )
        );

        $resource = $this->digitalOceanFileStorageManager->readFile(
            sprintf('%s%s',$this->projectDigitalOceanStoragePath,$resourcePath)
        );

        return new StreamedResponse(
            fn () =>
            fpassthru($resource),
            200,
            [
                'Content-Transfer-Encoding', 'binary',
                'Content-Type' => 'application/pdf',
            ]
        );


//        $tempUrl = $this->digitalOceanFileStorageManager->readTempUrl(
//            sprintf('%s%s',$this->projectDigitalOceanStoragePath,$resourcePath)
//        );

//        return new StreamedResponse(function () use ($resource) {
//            fpassthru($resource);
////            exit();
//        }, 200, [
//            'Content-Transfer-Encoding', 'binary',
//            'Content-Type' => 'application/pdf',
////            'Content-Disposition' => sprintf('attachment; filename="%s.pdf"', 'policy'),
////            'Content-Length' => fstat($resource)['size']
//        ]);





//        return new BinaryFileResponse(
//            $tempUrl
//        );

//        return new JsonResponse(
//            $tempUrl,
//            Response::HTTP_OK
//        );
    }


}