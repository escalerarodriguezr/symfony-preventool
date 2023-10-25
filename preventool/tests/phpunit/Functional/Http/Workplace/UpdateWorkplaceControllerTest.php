<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Workplace;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace\UpdateWorkplaceRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UpdateWorkplaceControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/workplace/%s';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDataBase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class
        ]);
    }

    public function testUpdateWorkplaceCompanySuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateWorkplaceRequest::NAME => 'fake-name',
            UpdateWorkplaceRequest::CONTACT_PHONE => '968636363',
            UpdateWorkplaceRequest::ADDRESS => 'Barrio de Rivendel 16',
            UpdateWorkplaceRequest::NUMBER_OF_WORKERS => 1000
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID, WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

    }

    public function testUnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateWorkplaceRequest::NAME => '',
            UpdateWorkplaceRequest::CONTACT_PHONE => '',
            UpdateWorkplaceRequest::ADDRESS => '',
            UpdateWorkplaceRequest::NUMBER_OF_WORKERS => 'fake'
        ];

        self::$authenticatedRootClient->request(Request::METHOD_PUT,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID, WorkplaceFixtures::class),
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
        self::assertArrayHasKey(UpdateWorkplaceRequest::NAME,$errors);
        self::assertArrayHasKey(UpdateWorkplaceRequest::CONTACT_PHONE,$errors);
        self::assertArrayHasKey(UpdateWorkplaceRequest::ADDRESS,$errors);
        self::assertArrayHasKey(UpdateWorkplaceRequest::NUMBER_OF_WORKERS,$errors);

    }

}