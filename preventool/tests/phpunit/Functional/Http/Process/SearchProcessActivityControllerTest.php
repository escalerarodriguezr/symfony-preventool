<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Process;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\Process\SearchProcessActivity\SearchProcessActivityResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchProcessActivityControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/process-activity';

    public function setUp():void
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
            ProcessFixtures::class,
            ProcessActivityFixtures::class
        ]);
    }

    public function testSearchProcessActivity(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();


        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            self::END_POINT
        );

        $response = self::$authenticatedRootClient->getResponse();

        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertArrayHasKey(SearchProcessActivityResponse::TOTAL,$responseData);
        self::assertArrayHasKey(SearchProcessActivityResponse::PAGES,$responseData);
        self::assertArrayHasKey(SearchProcessActivityResponse::CURRENT_PAGE,$responseData);
        self::assertArrayHasKey(SearchProcessActivityResponse::ITEMS,$responseData);

    }


}