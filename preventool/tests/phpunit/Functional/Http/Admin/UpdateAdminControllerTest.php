<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Admin;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/admin';
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

    public function testUpdateAdmin_WithRootActionAdmin_SuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'role' => AdminRole::ADMIN_ROLE_ROOT,
            'name' => 'kevin',
            'lastName' => 'Leonard',
            'email' => 'kevin@email.com'
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

    public function testWhenUpdateAdminWithActionAdminWithAminRoleShouldBeResponseActionNotAllowedException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            'lastName' => 'Leonard',
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, AdminFixtures::ROOT_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());

    }

    public function testWhenActionAdmin_WithAminRole_TryUpdateItSelf_ShouldBesuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            'lastName' => 'Leonard',
        ];

        self::$authenticatedAdminClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', self::END_POINT, AdminFixtures::ADMIN_ADMIN_UUID),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

}