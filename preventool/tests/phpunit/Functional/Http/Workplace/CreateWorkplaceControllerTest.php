<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Workplace;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Listener\Shared\JsonTransformerExceptionListener;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace\CreateWorkplaceRequest;
use Preventool\Infrastructure\Ui\Http\Service\HttpRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateWorkplaceControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/workplace';
    public function setUp():void
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

    public function testCreateWorkplaceSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateWorkplaceRequest::NAME => 'RivenderWorkPlace',
            CreateWorkplaceRequest::CONTACT_PHONE => '942824021',
            CreateWorkplaceRequest::ADDRESS => 'Barrio de Bree 16',
            CreateWorkplaceRequest::NUMBER_OF_WORKERS => 500
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID),
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

        $query = sprintf(
            'SELECT id, workplace_id, category FROM baseline_study WHERE workplace_id = "%s"',
            $responseData[HttpRequestService::ID]
        );
        $firstIndicator = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(
            $responseData[HttpRequestService::ID],
            $firstIndicator['workplace_id']
        );

        $query = sprintf(
            'SELECT id, workplace_id, total_compliance FROM baseline_study_compliance WHERE workplace_id = "%s"',
            $responseData[HttpRequestService::ID]
        );
        $firstIndicator = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(
            $responseData[HttpRequestService::ID],
            $firstIndicator['workplace_id']
        );

        self::assertSame(
            0,
            $firstIndicator['total_compliance']
        );
    }



    public function testUnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            CreateWorkplaceRequest::NAME => '',
            CreateWorkplaceRequest::CONTACT_PHONE => '',
            CreateWorkplaceRequest::ADDRESS => '',
            CreateWorkplaceRequest::NUMBER_OF_WORKERS => 'fake'
        ];

        self::$authenticatedRootClient->request(Request::METHOD_POST,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID),
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
        self::assertArrayHasKey(CreateWorkplaceRequest::NAME,$errors);
        self::assertArrayHasKey(CreateWorkplaceRequest::CONTACT_PHONE,$errors);
        self::assertArrayHasKey(CreateWorkplaceRequest::ADDRESS,$errors);
        self::assertArrayHasKey(CreateWorkplaceRequest::NUMBER_OF_WORKERS,$errors);

    }

    public function testWhenCreateRivendelWorkplace_1_ShouldBeResponseWorkplaceAlreadyExistsException()
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class
        ]);
        $this->authenticatedRootClient();

        $payload = [
            CreateWorkplaceRequest::NAME => WorkplaceFixtures::RIVENDEL_WORKPLACE_1_NAME,
            CreateWorkplaceRequest::CONTACT_PHONE => '942824021',
            CreateWorkplaceRequest::ADDRESS => 'Barrio de Bree 16',
            CreateWorkplaceRequest::NUMBER_OF_WORKERS => 500
        ];

        self::$authenticatedRootClient->request(
            sprintf(Request::METHOD_POST,CompanyFixtures::RIVENDEL_UUID),
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_CONFLICT,$response->getStatusCode());
    }

}