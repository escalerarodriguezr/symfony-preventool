<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Admin;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Admin\CreateAdminRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class CreateAdminControllerTest extends FunctionalHttpTestBase
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

    public function testSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();


        /* @var InMemoryTransport $transport */
        $transport = $this->getContainer()->get('messenger.transport.async');



        $payload = [
            'email' => 'leoanar@api.com',
            'password' => 'password123',
            'role' => AdminRole::ADMIN_ROLE_ROOT,
            'name' => 'Kawhi',
            'lastName' => 'Leonard'
        ];

        self::$authenticatedRootClient->request(Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CREATED,$response->getStatusCode());

        $response = json_decode($response->getContent(), true);
        self::assertArrayHasKey(HttpRequestService::ID, $response);
        self::assertIsValidUuid($response[HttpRequestService::ID]);

        $this->assertCount(1, $transport->getSent());

    }

    public function testUnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            'email' => '',
            'password' => '',
            'role' => '',
            'name' => '',
            'lastName' => ''
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
        self::assertArrayHasKey(CreateAdminRequest::NAME,$errors);
        self::assertArrayHasKey(CreateAdminRequest::LAST_NAME,$errors);
        self::assertArrayHasKey(CreateAdminRequest::EMAIL,$errors);
        self::assertArrayHasKey(CreateAdminRequest::PASSWORD,$errors);
        self::assertArrayHasKey(CreateAdminRequest::ROLE,$errors);
    }

    public function testWhenCreateAdminWithActionAdminWithAminRoleShouldBeResponseActionNotAllowedException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedAdminClient();

        $payload = [
            'email' => 'kevin@api.com',
            'password' => 'password123',
            'role' => AdminRole::ADMIN_ROLE_ADMIN,
            'name' => 'kevin',
            'lastName' => 'Leonard'
        ];

        self::$authenticatedAdminClient->request(Request::METHOD_POST,
            self::END_POINT,
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());
    }

}