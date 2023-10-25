<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\AuditType;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\Audit\Exception\AuditTypeAlreadyExistsException;
use Preventool\Domain\Audit\Exception\CreateAuditTypeCommandInvalidCommandException;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AuditTypeFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\AuditType\CreateAuditTypeRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateAuditTypeControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/audit-type';

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
            WorkplaceFixtures::class
        ]);
    }

    public function testUnprocessableEntityHttpExceptionResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'name' => 'A',
            'description' => 'A',
            'companyId' => 'fake',
            'workplaceId' => 'fake',
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
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());
        $response = json_decode($response->getContent(),true);
        self::assertArrayHasKey(JsonTransformerExceptionListener::ERRORS_KEY,$response);
        $errors = $response[JsonTransformerExceptionListener::ERRORS_KEY];
        self::assertArrayHasKey(CreateAuditTypeRequest::NAME,$errors);
        self::assertArrayHasKey(CreateAuditTypeRequest::DESCRIPTION,$errors);
        self::assertArrayHasKey(CreateAuditTypeRequest::COMPANY_ID,$errors);
        self::assertArrayHasKey(CreateAuditTypeRequest::WORKPLACE_ID,$errors);

    }

    public function testCreateSystemAuditTypeSuccessResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'name' => 'Audit test',
            'description' => 'Audit test description'
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

        self::assertSame(
            Response::HTTP_CREATED,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HttpRequestService::ID,
            $responseData
        );

        $this->assertIsValidUuid(
            $responseData[HttpRequestService::ID]
        );

    }

    public function testCreateSystemAuditTypeNotDescriptionParamSuccessResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'name' => 'Audit test2',
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

        self::assertSame(
            Response::HTTP_CREATED,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HttpRequestService::ID,
            $responseData
        );

        $this->assertIsValidUuid(
            $responseData[HttpRequestService::ID]
        );

    }

    public function testCreateRivendelCompanyAuditTypeSuccessResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateAuditTypeRequest::NAME => 'Audit test',
            CreateAuditTypeRequest::DESCRIPTION => 'Audit test description',
            CreateAuditTypeRequest::COMPANY_ID => CompanyFixtures::RIVENDEL_UUID
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

        self::assertSame(
            Response::HTTP_CREATED,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HttpRequestService::ID,
            $responseData
        );

        $this->assertIsValidUuid(
            $responseData[HttpRequestService::ID]
        );

    }



    public function testCreateRivendelWorkplace_1_AuditTypeSuccessResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateAuditTypeRequest::NAME => 'Audit test',
            CreateAuditTypeRequest::DESCRIPTION => 'Audit test description',
            CreateAuditTypeRequest::WORKPLACE_ID => WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
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

        self::assertSame(
            Response::HTTP_CREATED,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            HttpRequestService::ID,
            $responseData
        );

        $this->assertIsValidUuid(
            $responseData[HttpRequestService::ID]
        );

    }

    public function testCreateAuditTypeWithCompanyAndWorkplaceCreateAuditTypeCommandInvalidCommandExceptionResponse(): void
    {

        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateAuditTypeRequest::NAME => 'Audit test',
            CreateAuditTypeRequest::DESCRIPTION => 'Audit test description',
            CreateAuditTypeRequest::COMPANY_ID => CompanyFixtures::RIVENDEL_UUID,
            CreateAuditTypeRequest::WORKPLACE_ID => WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
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


        self::assertEquals(
            Response::HTTP_CONFLICT,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            JsonTransformerExceptionListener::CLASS_KEY,
            $responseData
        );

        self::assertSame(
            CreateAuditTypeCommandInvalidCommandException::class,
            $responseData[JsonTransformerExceptionListener::CLASS_KEY]
        );


    }

    public function testCreateAuditTypeAlreadyExistsExceptionResponse(): void
    {

        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class,
            AuditTypeFixtures::class
        ]);
        $this->authenticatedRootClient();

        $payload = [
            CreateAuditTypeRequest::NAME => AuditTypeFixtures::AUDIT_TYPE_SYSTEM_NAME,
            CreateAuditTypeRequest::DESCRIPTION => 'Audit test description',
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


        self::assertEquals(
            Response::HTTP_CONFLICT,
            $response->getStatusCode()
        );

        $responseData = json_decode(
            $response->getContent(),
            true
        );

        self::assertArrayHasKey(
            JsonTransformerExceptionListener::CLASS_KEY,
            $responseData
        );

        self::assertSame(
            AuditTypeAlreadyExistsException::class,
            $responseData[JsonTransformerExceptionListener::CLASS_KEY]
        );

    }

}