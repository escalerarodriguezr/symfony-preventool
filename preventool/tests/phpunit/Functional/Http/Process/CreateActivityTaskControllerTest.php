<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\CreateActivityTaskRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateActivityTaskControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/activity/%s/task';

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
            ProcessFixtures::class,
            ProcessActivityFixtures::class
        ]);
    }

    public function testCreateActivityTaskSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateActivityTaskRequest::NAME => 'TaskName',
            CreateActivityTaskRequest::DESCRIPTION => 'TaskDescription'

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(self::END_POINT,ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_CREATED,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);
        self::assertIsValidUuid($responseData[HttpRequestService::ID]);

    }

    public function testCreateActivityTaskUnprocessableEntityResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(self::END_POINT,ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

    }


}