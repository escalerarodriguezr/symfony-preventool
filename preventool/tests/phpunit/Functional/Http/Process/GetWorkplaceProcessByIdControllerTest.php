<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceProcessByIdControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = '/api/v1/workplace/%s/process/%s';

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
            WorkplaceFixtures::class,
            ProcessFixtures::class
        ]);
    }

    public function testGetWorkplaceProcessSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(
                self::END_POINT,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
                ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
            )
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(ProcessResponse::ID, $responseData);
        self::assertSame(
            ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1,
            $responseData[ProcessResponse::ID]
        );
        self::assertSame(
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
            $responseData[ProcessResponse::WORKPLACE_ID]
        );

    }

}