<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\CreateCompanyRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCompanyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company';
    public function setUp():void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class
        ]);
    }

    public function testCreateCompanySuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateCompanyRequest::NAME => 'Rivendel',
            CreateCompanyRequest::LEGAL_NAME => 'Rivendel S.L',
            CreateCompanyRequest::LEGAL_DOCUMENT => '2011111111',
            CreateCompanyRequest::ADDRESS => 'La Tierra Media s/n',
            CreateCompanyRequest::SECTOR => 'Sanidad'

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        
        self::assertSame(Response::HTTP_CREATED,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(HttpRequestService::ID,$responseData);
        self::assertIsValidUuid($responseData[HttpRequestService::ID]);

    }

    public function testWhenAnAdminWithAdminRoleTriesToCreateACompanyShouldBeResponseActionNoAllowedException()
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            CreateCompanyRequest::NAME => 'Rivendel',
            CreateCompanyRequest::LEGAL_NAME => 'Rivendel S.L',
            CreateCompanyRequest::LEGAL_DOCUMENT => '2011111111',
            CreateCompanyRequest::ADDRESS => 'La Tierra Media s/n',
            CreateCompanyRequest::SECTOR => 'Sanidad'

        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();

        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

    public function testUnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateCompanyRequest::NAME => '',
            CreateCompanyRequest::LEGAL_NAME => '',
            CreateCompanyRequest::LEGAL_DOCUMENT => '',
            CreateCompanyRequest::ADDRESS => '',
            CreateCompanyRequest::SECTOR => ''

        ];

        self::$authenticatedRootClient->request(Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());
        $response = json_decode($response->getContent(),true);
        self::assertArrayHasKey(JsonTransformerExceptionListener::ERRORS_KEY,$response);
        $errors = $response[JsonTransformerExceptionListener::ERRORS_KEY];
        self::assertArrayHasKey(CreateCompanyRequest::NAME,$errors);
        self::assertArrayHasKey(CreateCompanyRequest::LEGAL_NAME,$errors);
        self::assertArrayHasKey(CreateCompanyRequest::LEGAL_DOCUMENT,$errors);
        self::assertArrayHasKey(CreateCompanyRequest::ADDRESS,$errors);
        self::assertArrayHasKey(CreateCompanyRequest::SECTOR,$errors);

    }

    public function testWhenCreateCompanyWithRivendelLegalDocumentShouldBeResponseCompanyAlreadyExistsException()
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class
        ]);
        $this->authenticatedRootClient();

        $payload = [
            CreateCompanyRequest::NAME => 'Fake-Company',
            CreateCompanyRequest::LEGAL_NAME => 'Fake S.L',
            CreateCompanyRequest::LEGAL_DOCUMENT => CompanyFixtures::RIVENDEL_LEGAL_DOCUMENT,
            CreateCompanyRequest::ADDRESS => 'La Tierra Media s/n',
            CreateCompanyRequest::SECTOR => 'Sanidad'

        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

}