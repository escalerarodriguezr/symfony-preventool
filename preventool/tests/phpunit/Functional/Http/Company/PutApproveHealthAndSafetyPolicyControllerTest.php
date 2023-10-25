<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\HealthAndSafetyPolicyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\HealthAndSafetyPolicyWithDocumentResourceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\assertSame;

class PutApproveHealthAndSafetyPolicyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/approve-health-and-safety-policy';

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

    public function testApproveHealthAndSafetyPolicySuccessResponse(): void
    {
        $this->prepareDatabase(true);
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            ),
        );

        $response = self::$authenticatedRootClient->getResponse();

        assertSame(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $query = sprintf(
            'SELECT id, status FROM health_and_safety_policy WHERE company_id = "%s"',
            CompanyFixtures::RIVENDEL_UUID
        );
        $policy = self::initDBConnection()->executeQuery(
            $query
        )->fetchAssociative();

        self::assertSame(
            DocumentStatus::APPROVED,
            $policy['status']
        );

    }

    public function testApproveHealthAndSafetyPolicyHealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            ),
        );

        $response = self::$authenticatedRootClient->getResponse();

        assertSame(
            Response::HTTP_CONFLICT,
            $response->getStatusCode()
        );

        $responseData = json_decode($response->getContent(),true);

        self::assertSame(
            HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException::class,
            $responseData[JsonTransformerExceptionListener::CLASS_KEY]
        );

    }


}