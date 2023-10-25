<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\OccupationalRisk;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
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
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\UpdateTaskRiskRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskRiskControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/task-risk/%s';

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

    public function testUpdateTaskRiskControllerSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateTaskRiskRequest::NAME => 'FakeRiskName',
            UpdateTaskRiskRequest::OBSERVATIONS => 'FakeRiskObservations',
            UpdateTaskRiskRequest::LEGAL_REQUIREMENT => 'FakeRiskLegalRequirement',
            UpdateTaskRiskRequest::HAZARD_NAME => 'FakeHazardName',
            UpdateTaskRiskRequest::HAZARD_DESCRIPTION => 'FakeHazardDescription'

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,TaskHazardFixtures::TASK_RISK_TASK_1_NOISES_ID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

    }


}