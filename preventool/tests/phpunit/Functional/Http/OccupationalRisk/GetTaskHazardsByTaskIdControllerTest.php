<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\OccupationalRisk;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\OccupationalRisk\Response\TaskHazardResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityTaskFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\TaskHazardFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardCategoryFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTaskHazardsByTaskIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/task/%s/hazards';

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
            WorkplaceHazardFixtures::class,
            TaskHazardFixtures::class
        ]);
    }

    public function testGetTaskHazardsSuccessResponse(): void
    {


        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(
                self::END_POINT,
                ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID
            )
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertSame(
            TaskHazardFixtures::TASK_1_NOISES_ID,
            $responseData[0][TaskHazardResponse::ID]
        );

        self::assertSame(
            WorkplaceHazardFixtures::NOISES_NAME,
            $responseData[0][TaskHazardResponse::HAZARD_NAME]
        );

        self::assertSame(
            TaskHazardFixtures::TASK_RISK_TASK_1_NOISES_ID,
            $responseData[0][TaskHazardResponse::RISK_ID]
        );

       self::assertArrayHasKey(
           TaskHazardResponse::STATUS,
           $responseData[0]
       );

    }


}