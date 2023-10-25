<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\UpdateCompanyRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCompanyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company';
    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class
        ]);
    }

    public function testUpdateCompany_WithRootActionAdmin_SuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateCompanyRequest::NAME => 'new-name',
            UpdateCompanyRequest::LEGAL_NAME => 'new-legal-name',
            UpdateCompanyRequest::LEGAL_DOCUMENT => '2088888888',
            UpdateCompanyRequest::ADDRESS => 'new-Address',
            UpdateCompanyRequest::SECTOR => 'new-sector'
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, CompanyFixtures::RIVENDEL_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

    public function testUpdateCompany_WithRoleRoot_UnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateCompanyRequest::NAME => ' ',
            UpdateCompanyRequest::LEGAL_NAME => ' ',
            UpdateCompanyRequest::LEGAL_DOCUMENT => ' ',
            UpdateCompanyRequest::ADDRESS => ' ',
            UpdateCompanyRequest::SECTOR => ' '
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, CompanyFixtures::RIVENDEL_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());

    }

    public function testWhenTryUpdteCompany_WithRoleAdminShouldBeResponseActionNotAllowedException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            UpdateCompanyRequest::NAME => 'new-name',
            UpdateCompanyRequest::LEGAL_NAME => 'new-legal-name',
            UpdateCompanyRequest::LEGAL_DOCUMENT => '2088888888',
            UpdateCompanyRequest::ADDRESS => 'new-Address',
            UpdateCompanyRequest::SECTOR => 'new-sector'
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, CompanyFixtures::RIVENDEL_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

}