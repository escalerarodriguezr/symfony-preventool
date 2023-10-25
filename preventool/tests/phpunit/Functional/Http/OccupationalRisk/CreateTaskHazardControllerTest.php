<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\OccupationalRisk;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityTaskFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardCategoryFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\CreateTaskHazardRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateTaskHazardControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/create-task-hazard';

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
            ProcessActivityFixtures::class,
            ProcessActivityTaskFixtures::class,
            WorkplaceHazardCategoryFixtures::class,
            WorkplaceHazardFixtures::class
        ]);
    }

    public function testCreateTaskHazardControllerSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateTaskHazardRequest::TASK_ID => ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID,
            CreateTaskHazardRequest::HAZARD_ID => WorkplaceHazardFixtures::NOISES_ID
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            self::END_POINT,
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CREATED,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);
        self::assertArrayHasKey(HttpRequestService::ID,$responseData);
        self::assertIsValidUuid($responseData[HttpRequestService::ID]);


        $query = sprintf(
            'SELECT id, task_hazard_id, name FROM task_risk WHERE task_hazard_id = "%s"',
            $responseData[HttpRequestService::ID]
        );
        $taskRisk = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(
            $responseData[HttpRequestService::ID],
            $taskRisk['task_hazard_id']
        );

        self::assertSame(
            sprintf('Riesgo-%s',WorkplaceHazardFixtures::NOISES_NAME),
            $taskRisk['name']
        );

    }

}