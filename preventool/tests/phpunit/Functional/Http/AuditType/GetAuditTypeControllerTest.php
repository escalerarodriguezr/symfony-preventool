<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\AuditType;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\AuditType\Response\AuditTypeResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AuditTypeFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class GetAuditTypeControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/audit-type/%s';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            AuditTypeFixtures::class
        ]);
    }

    public function testGetSystemAuditTypeSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,AuditTypeFixtures::AUDIT_TYPE_SYSTEM_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(
            AuditTypeResponse::ID,
            $responseData
        );

        self::assertSame(
            AuditTypeFixtures::AUDIT_TYPE_SYSTEM_UUID,
            $responseData[AuditTypeResponse::ID]
        );

        self::assertArrayHasKey(
            AuditTypeResponse::SCOPE,
            $responseData
        );

        self::assertSame(
            AuditTypeFixtures::AUDIT_TYPE_SYSTEM_SCOPE,
            $responseData[AuditTypeResponse::SCOPE]
        );

        self::assertArrayHasKey(
            AuditTypeResponse::NAME,
            $responseData
        );

        self::assertSame(
            AuditTypeFixtures::AUDIT_TYPE_SYSTEM_NAME,
            $responseData[AuditTypeResponse::NAME]
        );

        self::assertArrayHasKey(
            AuditTypeResponse::DESCRIPTION,
            $responseData
        );

        self::assertSame(
            AuditTypeFixtures::AUDIT_TYPE_SYSTEM_DESCRIPTION,
            $responseData[AuditTypeResponse::DESCRIPTION]
        );

        self::assertArrayHasKey(
            AuditTypeResponse::COMPANY_ID,
            $responseData
        );

        self::assertSame(
            null,
            $responseData[AuditTypeResponse::COMPANY_ID]
        );

    }

    public function testGetSystemAuditTypeAuditTypeNotFoundExpectionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $notFondId = '0302b5ff-67d6-4ae0-b778-d75ddd7cc4b5';

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,$notFondId)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_NOT_FOUND,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(
            JsonTransformerExceptionListener::CLASS_KEY,
            $responseData
        );

        self::assertStringEndsWith(
            'AuditTypeNotFoundException',
            $responseData[JsonTransformerExceptionListener::CLASS_KEY]
        );

    }

}