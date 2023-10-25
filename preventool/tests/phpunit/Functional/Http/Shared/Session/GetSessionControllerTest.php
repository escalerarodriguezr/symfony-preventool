<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Shared\Session;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Service\Session\SessionAdminResponse;
use Preventool\Infrastructure\Ui\Http\Service\Session\SessionResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSessionControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/session';
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

    public function testGetSessionWithNotAuthenticateClientAccessDeniedExceptionResponse(): void
    {
        $this->baseClient();
        $this->prepareDatabase();
        self::$baseClient->request(
            Request::METHOD_GET,
            self::END_POINT
        );

        $response = self::$baseClient->getResponse();
        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());

    }

    public function testGetSessionSuccessResponse(): void
    {
        $this->authenticatedRootClient();
        $this->prepareDatabase();
        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            self::END_POINT
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);

        self::assertArrayHasKey(SessionResponse::ACTION_USER_ID, $responseData);
        self::assertSame(UserFixtures::ROOT_UUID, $responseData[SessionResponse::ACTION_USER_ID]);

        self::assertArrayHasKey(SessionResponse::ADMIN, $responseData);
        $actionAdmin = $responseData[SessionResponse::ADMIN];

        self::assertArrayHasKey(SessionAdminResponse::ID,$actionAdmin);
        self::assertArrayHasKey(SessionAdminResponse::EMAIL,$actionAdmin);
        self::assertArrayHasKey(SessionAdminResponse::TYPE,$actionAdmin);
        self::assertArrayHasKey(SessionAdminResponse::ROLE,$actionAdmin);
        self::assertArrayHasKey(SessionAdminResponse::NAME,$actionAdmin);
        self::assertArrayHasKey(SessionAdminResponse::LAST_NAME,$actionAdmin);

        self::assertSame(AdminFixtures::ROOT_ADMIN_UUID,$actionAdmin[SessionAdminResponse::ID]);
        self::assertSame(AdminFixtures::ROOT_ADMIN_EMAIL,$actionAdmin[SessionAdminResponse::EMAIL]);
        self::assertSame(AdminFixtures::ROOT_ADMIN_TYPE,$actionAdmin[SessionAdminResponse::TYPE]);
        self::assertSame(AdminFixtures::ROOT_ADMIN_ROLE,$actionAdmin[SessionAdminResponse::ROLE]);
        self::assertSame(AdminFixtures::ROOT_ADMIN_NAME,$actionAdmin[SessionAdminResponse::NAME]);
        self::assertSame(AdminFixtures::ROOT_ADMIN_LASTNAME,$actionAdmin[SessionAdminResponse::LAST_NAME]);

    }

}