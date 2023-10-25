<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\BaselineStudy;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\BaselineStudy\UpdateBaselineStudyIndicatorRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutBaselineStudyIndicatorControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/update-baseline-study-indicator/%s/%s';
    const INDICATOR_PRINCIPIOS_1 = 'principios-1';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase() :void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class
        ]);
    }

    public function testPutBaselineStudyIndicatorSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateBaselineStudyIndicatorRequest::OBSERVATIONS => "observations",
            UpdateBaselineStudyIndicatorRequest::COMPLIANCE_PERCENTAGE => 100
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(
                self::END_POINT,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
                self::INDICATOR_PRINCIPIOS_1
            ),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());


        $query = sprintf(
            'SELECT id, workplace_id, total_compliance, compromiso_compliance FROM baseline_study_compliance WHERE workplace_id = "%s"',
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
        );
        $baselineStudyCompliance = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertNotSame(
            0,
            $baselineStudyCompliance['total_compliance']
        );

        self::assertNotSame(
            0,
            $baselineStudyCompliance['compromiso_compliance']
        );

    }

}