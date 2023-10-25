<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Workplace;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Workplace\Response\WorkplaceResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceByIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/workplace/%s';

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

    public function testGetWorkplaceByIdSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
            )
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(WorkplaceResponse::ID, $responseData);
        self::assertSame(CompanyFixtures::RIVENDEL_UUID, $responseData[WorkplaceResponse::COMPANY_ID]);
        self::assertSame(WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID, $responseData[WorkplaceResponse::ID]);
        self::assertArrayHasKey(WorkplaceResponse::NAME, $responseData);
        self::assertArrayHasKey(WorkplaceResponse::CONTACT_PHONE, $responseData);
        self::assertArrayHasKey(WorkplaceResponse::ADDRESS, $responseData);
        self::assertArrayHasKey(WorkplaceResponse::NUMBER_OF_WORKERS, $responseData);
        self::assertArrayHasKey(WorkplaceResponse::ACTIVE, $responseData);

    }




}