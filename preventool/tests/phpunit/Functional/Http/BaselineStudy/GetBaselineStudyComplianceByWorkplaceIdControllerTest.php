<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\BaselineStudy;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\BaselineStudy\Response\BaselineStudyComplianceResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetBaselineStudyComplianceByWorkplaceIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/baseline-study-compliance/%s';

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

    public function testGetBaselineStudyComplianceSuccessResponse(): void
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
        self::assertIsArray($responseData);
        self::assertSame(
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
            $responseData[BaselineStudyComplianceResponse::WORKPLACE_ID]
        );
        self::assertArrayHasKey(BaselineStudyComplianceResponse::TOTAL_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::COMPROMISO_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::POLITICA_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::PLANEAMIENTO_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::IMPLEMENTACION_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::EVALUACION_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::VERIFICACION_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::CONTROL_COMPLIANCE,$responseData);
        self::assertArrayHasKey(BaselineStudyComplianceResponse::REVISION_COMPLIANCE,$responseData);

    }


}