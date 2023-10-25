<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\WorkplaceHazard;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Application\WorkplaceHazard\Response\WorkplaceHazardResponse;
use Preventool\Application\WorkplaceHazard\SearchWorkplaceHazard\SearchWorkplaceHazardResponse;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessActivityTaskFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\ProcessFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\TaskHazardFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardCategoryFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceHazardFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\WorkplaceHazard\SearchWorkplaceHazardRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchWorkplaceHazardControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/workplace/%s/search-hazard';

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
            ProcessFixtures::class,
            ProcessActivityFixtures::class,
            ProcessActivityTaskFixtures::class,
            WorkplaceHazardCategoryFixtures::class,
            WorkplaceHazardFixtures::class,
            TaskHazardFixtures::class
        ]);
    }

    public function testSearchWorkplaceHazardSuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

//        $query = [
//            SearchWorkplaceHazardRequest::FILTER_BY_NOT_HAS_TASK_HAZARD_WITH_TASK_ID => ProcessActivityTaskFixtures::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID
//        ];

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        foreach ($responseData[SearchWorkplaceHazardResponse::ITEMS] as $hazard){
            self::assertArrayHasKey(
                WorkplaceHazardResponse::NAME,
                $hazard
            );
            self::assertArrayHasKey(
                WorkplaceHazardResponse::CATEGORY_NAME,
                $hazard
            );

            self::assertArrayHasKey(
                WorkplaceHazardResponse::WORKPLACE_ID,
                $hazard
            );
        }

    }

}