<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Workplace;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Workplace\GetWorkplaceDashboard\Response\WorkplaceDashboardResponse;
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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceDashboardControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/workplace/%s/dashboard';

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
            TaskHazardFixtures::class,
            TaskRiskAssessmentFixtures::class
        ]);
    }

    public function testGetWorkplaceDashboardSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::BASELINE_STUDY_TOTAL_COMPLIANCE,
            $responseData
        );

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::TASK_RISK_TOTAL_NUMBER,
            $responseData
        );

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::TASK_RISK_STATUS_PENDING_NUMBER,
            $responseData
        );

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::TASK_RISK_STATUS_DRAFT_NUMBER,
            $responseData
        );

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::TASK_RISK_STATUS_REVISED_NUMBER,
            $responseData
        );

        self::assertArrayHasKey(
            WorkplaceDashboardResponse::TASK_RISK_STATUS_APPROVED_NUMBER,
            $responseData
        );
    }


}