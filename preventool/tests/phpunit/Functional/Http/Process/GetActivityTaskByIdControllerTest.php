<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Process\Response\ProcessActivityTaskResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityTaskFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetActivityTaskByIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/activity-task/%s';

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
            ProcessActivityTaskFixtures::class
        ]);
    }

    public function testGetActivityTaskByIdSuccessResponse():void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();
        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID)
        );
        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertSame(
            ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID,
            $responseData[ProcessActivityTaskResponse::ID]
        );

        self::assertSame(
            ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID,
            $responseData[ProcessActivityTaskResponse::PROCESS_ACTIVITY_ID]
        );

    }


}