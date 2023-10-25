<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Company\Response\HealthAndSafetyPolicyResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\HealthAndSafetyPolicyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\HealthAndSafetyPolicyWithDocumentResourceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetHealthAndSafetyPolicyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/health-and-safety-policy';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(bool $withDocumentResource = false) :void
    {

        if( false === $withDocumentResource ){
            $this->databaseTool->loadFixtures([
                UserFixtures::class,
                AdminFixtures::class,
                CompanyFixtures::class,
                HealthAndSafetyPolicyFixtures::class
            ]);
        }else{
            $this->databaseTool->loadFixtures([
                UserFixtures::class,
                AdminFixtures::class,
                CompanyFixtures::class,
                HealthAndSafetyPolicyWithDocumentResourceFixtures::class
            ]);
        }
    }

    public function testGetHealthAndSafetyPolicyNotDocumentResourceSuccessResponse()
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            )
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::ID,
            $responseData
        );
        self::assertSame(
            HealthAndSafetyPolicyFixtures::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_UUID,
            $responseData[HealthAndSafetyPolicyResponse::ID]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::COMPANY_ID,
            $responseData
        );
        self::assertSame(
            CompanyFixtures::RIVENDEL_UUID,
            $responseData[HealthAndSafetyPolicyResponse::COMPANY_ID]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::STATUS,
            $responseData
        );
        self::assertSame(
            HealthAndSafetyPolicyFixtures::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_STATUS,
            $responseData[HealthAndSafetyPolicyResponse::STATUS]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::DOCUMENT_RESOURCE,
            $responseData
        );
        self::assertSame(
            null,
            $responseData[HealthAndSafetyPolicyResponse::DOCUMENT_RESOURCE]
        );

    }

    public function testGetHealthAndSafetyPolicyWithDocumentResourceSuccessResponse()
    {
        $this->prepareDatabase(true);
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            )
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::ID,
            $responseData
        );
        self::assertSame(
            HealthAndSafetyPolicyWithDocumentResourceFixtures::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_UUID,
            $responseData[HealthAndSafetyPolicyResponse::ID]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::COMPANY_ID,
            $responseData
        );
        self::assertSame(
            CompanyFixtures::RIVENDEL_UUID,
            $responseData[HealthAndSafetyPolicyResponse::COMPANY_ID]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::STATUS,
            $responseData
        );
        self::assertSame(
            HealthAndSafetyPolicyWithDocumentResourceFixtures::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_STATUS,
            $responseData[HealthAndSafetyPolicyResponse::STATUS]
        );

        self::assertArrayHasKey(
            HealthAndSafetyPolicyResponse::DOCUMENT_RESOURCE,
            $responseData
        );
        self::assertSame(
            HealthAndSafetyPolicyWithDocumentResourceFixtures::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_DOCUMENT_RESOURCE,
            $responseData[HealthAndSafetyPolicyResponse::DOCUMENT_RESOURCE]
        );

    }


}