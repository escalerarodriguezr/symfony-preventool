<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Admin;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\UpdateAdminPasswordRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminPasswordControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/admin/%s/password';
    public function setUp(): void
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

    public function testUpdateAdminPassword_WithRootActionAdmin_SuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateAdminPasswordRequest::CURRENT_PASSWORD => AdminFixtures::ROOT_ADMIN_PASSWORD,
            UpdateAdminPasswordRequest::PASSWORD => 'qwertyuiop',
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            \sprintf(self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

    public function testUpdateAdminPassword_WithRootActionAdmin_ErrorCurrentPassword_Response(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateAdminPasswordRequest::CURRENT_PASSWORD => 'invalid-password',
            UpdateAdminPasswordRequest::PASSWORD => 'qwertyuiop',
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            \sprintf(self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());
    }

    public function testWhenUpdateAdminPasswordWith_ActionAdminWithAminRole_ShouldBeResponseActionNotAllowedException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            UpdateAdminPasswordRequest::CURRENT_PASSWORD => AdminFixtures::ADMIN_ADMIN_PASSWORD,
            UpdateAdminPasswordRequest::PASSWORD => 'qwertyuiop',
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf(self::END_POINT, AdminFixtures::ROOT_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

    public function testWhenActionAdmin_WithAminRole_TryUpdateItSelf_ShouldBeResponseSuccess(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            UpdateAdminPasswordRequest::CURRENT_PASSWORD => AdminFixtures::ADMIN_ADMIN_PASSWORD,
            UpdateAdminPasswordRequest::PASSWORD => 'qwertyuiop',
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf(self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

    public function testWhenInvalidCurrentPassword_ShouldBeConflictException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            UpdateAdminPasswordRequest::CURRENT_PASSWORD => 'invalid-current-password',
            UpdateAdminPasswordRequest::PASSWORD => 'qwertyuiop',
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf(self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

}