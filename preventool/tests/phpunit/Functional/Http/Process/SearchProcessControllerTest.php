<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Application\Process\SearchProcess\SearchProcessResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Process\SearchProcessRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchProcessControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = '/api/v1/process';

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

    public function testSearchWorkplaceProcessFilterByNameAndWorkplace(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $filters = [
            SearchProcessRequest::FILTER_BY_NAME => ProcessFixtures::CONFECCION_PROCESS_NAME_RIVENDEL_WORKPLACE_1,
            SearchProcessRequest::FILTER_BY_WORKPLACE_ID => WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            self::END_POINT,
            $filters
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());


        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(SearchProcessResponse::TOTAL,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::PAGES,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::CURRENT_PAGE,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::ITEMS,$responseData);

        self::assertSame(1,$responseData[SearchProcessResponse::TOTAL]);

        $items = $responseData[SearchProcessResponse::ITEMS];
        $first = $items[0];

        self::assertSame(
            $first[ProcessResponse::ID]
            ,ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
        );

    }

    public function testSearchWorkplaceProcessFilterById(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $filters = [
            SearchProcessRequest::FILTER_BY_ID => ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            self::END_POINT,
            $filters
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());


        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(SearchProcessResponse::TOTAL,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::PAGES,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::CURRENT_PAGE,$responseData);
        self::assertArrayHasKey(SearchProcessResponse::ITEMS,$responseData);

        self::assertSame(1,$responseData[SearchProcessResponse::TOTAL]);

        $items = $responseData[SearchProcessResponse::ITEMS];
        $first = $items[0];

        self::assertSame(
            $first[ProcessResponse::ID]
            ,ProcessFixtures::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1
        );

    }

}