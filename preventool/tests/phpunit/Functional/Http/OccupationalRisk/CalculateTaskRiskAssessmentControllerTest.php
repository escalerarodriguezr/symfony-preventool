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
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\TaskRiskAssessmentFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardCategoryFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk\CalculateTaskRiskAssessmentRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalculateTaskRiskAssessmentControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/task-risk/%s/calculate-assessment';

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

    private function prepareDatabaseOnUpdateTest(): void
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
            TaskHazardFixtures::class,
            TaskRiskAssessmentFixtures::class
        ]);
    }

    public function testCalculateTaskRiskAssessmentOnCreate(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CalculateTaskRiskAssessmentRequest::EXPOSURE_INDEX => 1,
            CalculateTaskRiskAssessmentRequest::PEOPLE_EXPOSED_INDEX => 2,
            CalculateTaskRiskAssessmentRequest::PROCEDURE_INDEX => 2,
            CalculateTaskRiskAssessmentRequest::TRAINING_INDEX => 1,
            CalculateTaskRiskAssessmentRequest::SEVERITY_INDEX => 2
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,TaskHazardFixtures::TASK_RISK_TASK_1_NOISES_ID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

    }

    public function testCalculateTaskRiskAssessmentOnUpdate(): void
    {
        $this->prepareDatabaseOnUpdateTest();
        $this->authenticatedRootClient();

        $payload = [
            CalculateTaskRiskAssessmentRequest::EXPOSURE_INDEX => 1,
            CalculateTaskRiskAssessmentRequest::PEOPLE_EXPOSED_INDEX => 2,
            CalculateTaskRiskAssessmentRequest::PROCEDURE_INDEX => 2,
            CalculateTaskRiskAssessmentRequest::TRAINING_INDEX => 1,
            CalculateTaskRiskAssessmentRequest::SEVERITY_INDEX => 2
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,TaskHazardFixtures::TASK_RISK_TASK_1_NOISES_ID),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

    }


}