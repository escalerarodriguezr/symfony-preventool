<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityTaskFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\ReorderProcessActivityTasksRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReorderProcessActivityTasksControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/process-activity/%s/reorder-tasks';

    public function setUp():void
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

    public function testReorderProcessActivityTasksSuccessResponse():void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            ReorderProcessActivityTasksRequest::ORDER => [
                ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_UUID,
                ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID
            ]
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_UUID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT task_order FROM process_activity_task WHERE id = "%s"',
            ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID
        );
        $processActivity = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(
            2,
            $processActivity['task_order']
        );

    }


}