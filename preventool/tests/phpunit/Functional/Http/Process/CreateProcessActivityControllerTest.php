<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\CreateProcessActivityRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateProcessActivityControllerTest extends FunctionalHttpTestBase
{
    const END_POINT  = 'api/v1/process/%s/activity';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class,
            ProcessFixtures::class
        ]);
    }

    public function testCreateProcessActivitySuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'name' => 'Actividad 1',
            'description' => 'Una descripción de la actividad 1....'
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(
                self::END_POINT,
                ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
            ),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CREATED,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(HttpRequestService::ID,$responseData);
        self::assertIsValidUuid($responseData[HttpRequestService::ID]);

    }

    public function testCreateProcessActivityUnprocessableEntityExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'name' => '',
            'description' => ''
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(
                self::END_POINT,
                ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
            ),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);
        self::assertArrayHasKey(JsonTransformerExceptionListener::ERRORS_KEY,$responseData);
        $errors = $responseData[JsonTransformerExceptionListener::ERRORS_KEY];
        self::assertArrayHasKey(CreateProcessActivityRequest::NAME,$errors);
        self::assertArrayHasKey(CreateProcessActivityRequest::DESCRIPTION,$errors);

    }

}