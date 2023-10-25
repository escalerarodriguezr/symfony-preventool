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
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\ReorderProcessActivitiesRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReorderProcessActivitiesControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/process/%s/reorder-activities';

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

    public function testReorderProcessActivitiesControllerSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            ReorderProcessActivitiesRequest::ORDER => [
                ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_2_UUID,
                ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID,

            ]
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT activity_order FROM process_activity WHERE id = "%s"',
            ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID
        );
        $processActivity = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(
            2,
            $processActivity['activity_order']
        );

    }

    public function testReorderProcessActivitiesControllerUnprocessableEntityExceptionBlankOrderParam(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            ReorderProcessActivitiesRequest::ORDER => [

            ]
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

    }

    public function testReorderProcessActivitiesControllerUnprocessableEntityExceptionInvalidUuid(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            ReorderProcessActivitiesRequest::ORDER => [
                'invalid-uuid'
            ]
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

    }


}