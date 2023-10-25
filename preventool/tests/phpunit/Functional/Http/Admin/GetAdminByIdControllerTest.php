<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Admin;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Admin\Response\AdminResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAdminByIdControllerTest extends FunctionalHttpTestBase
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

    public function testGetAdminById_WithRootActionAdmin_SuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', self::END_POINT, AdminFixtures::ROOT_ADMIN_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);

        self::assertArrayHasKey(AdminResponse::ID, $responseData);
        self::assertSame(AdminFixtures::ROOT_ADMIN_UUID, $responseData[AdminResponse::ID]);
        self::assertArrayHasKey(AdminResponse::NAME, $responseData);
        self::assertArrayHasKey(AdminResponse::LAST_NAME, $responseData);
        self::assertArrayHasKey(AdminResponse::ROLE, $responseData);
        self::assertArrayHasKey(AdminResponse::TYPE, $responseData);
        self::assertArrayHasKey(AdminResponse::ACTIVE, $responseData);
        self::assertArrayHasKey(AdminResponse::CREATED_AT, $responseData);
        self::assertArrayHasKey(AdminResponse::UPDATED_AT, $responseData);
        self::assertArrayHasKey(AdminResponse::CREATOR_ID, $responseData);
        self::assertArrayHasKey(AdminResponse::UPDATER_ID, $responseData);
    }

    public function testWhenGetAdminById_WithActionAdminWithAminRole_ShouldBeResponseActionNotAllowedException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        self::$authenticatedAdminClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', self::END_POINT, AdminFixtures::ROOT_ADMIN_UUID)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());
    }
    
}