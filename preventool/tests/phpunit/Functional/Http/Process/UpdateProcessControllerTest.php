<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\UpdateProcessRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateProcessControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/workplace/%s/process/%s';

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

    public function testUpdateProcessSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateProcessRequest::NAME => 'Nombre nuevo',
            UpdateProcessRequest::DESCRIPTION => 'Descripción nueva'
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(
                self::END_POINT,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
                ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
            ),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

    }

    public function testUpdateProcessUnprocessableEntityException(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $payload = [
            UpdateProcessRequest::NAME => '',
            UpdateProcessRequest::DESCRIPTION => ''
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(
                self::END_POINT,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
                ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
            ),
            [],[],[],
            json_encode($payload)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY,$response->getStatusCode());
        
    }


}