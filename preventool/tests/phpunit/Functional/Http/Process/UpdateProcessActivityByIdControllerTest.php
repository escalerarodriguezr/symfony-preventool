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
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\UpdateProcessActivityRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateProcessActivityByIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/process-activity/%s';

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

    public function testUpdateProcessActivityByIdSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateProcessActivityRequest::NAME => 'updated-name',
            UpdateProcessActivityRequest::DESCRIPTION => 'updated-description'

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

    }

    public function testUpdateProcessActivityUnprocessableEntityException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateProcessActivityRequest::NAME => '',

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());
    }
}