<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Company\Response\CompanyResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCompanyByIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase() :void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class
        ]);
    }

    public function testGetCompabyByIdSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(CompanyResponse::ID, $responseData);
        self::assertSame(CompanyFixtures::RIVENDEL_UUID, $responseData[CompanyResponse::ID]);
        self::assertArrayHasKey(CompanyResponse::NAME, $responseData);
        self::assertArrayHasKey(CompanyResponse::LEGAL_NAME, $responseData);
        self::assertArrayHasKey(CompanyResponse::LEGAL_DOCUMENT, $responseData);
        self::assertArrayHasKey(CompanyResponse::ADDRESS, $responseData);
        self::assertArrayHasKey(CompanyResponse::SECTOR, $responseData);
        self::assertArrayHasKey(CompanyResponse::ACTIVE, $responseData);
        self::assertArrayHasKey(CompanyResponse::CREATED_AT, $responseData);
        self::assertArrayHasKey(CompanyResponse::UPDATED_AT, $responseData);
        self::assertArrayHasKey(CompanyResponse::CREATOR_ID, $responseData);
        self::assertArrayHasKey(CompanyResponse::UPDATER_ID, $responseData);

    }

    public function testWhenAnAdminWithAdminRoleTriesToGetACompanyByIdShouldBeResponseActionNoAllowedException()
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();
        self::$authenticatedAdminClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID)
        );
        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT, $response->getStatusCode());

    }
}