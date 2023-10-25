<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\BaselineStudy;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetWorkplaceBaselineStudyIndicatorsByCategoryControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/workplace-baseline-study-indicators-by-category/%s/%s';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase() :void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            WorkplaceFixtures::class
        ]);
    }

    public function testGetPercentageAndObservationsSuccessResponse(): void
    {
        self::assertSame(1,1);
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_GET,
            sprintf(self::END_POINT,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID,
                BaselineIndicatorCategory::CATEGORY_COMPROMISO
            )
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $responseData = json_decode($response->getContent(),true);

        self::assertIsArray($responseData);

        list($firstIndicator) = $responseData;

        self::assertIsArray($firstIndicator);
        self::assertArrayHasKey('category', $firstIndicator);
        self::assertSame(
            BaselineIndicatorCategory::CATEGORY_COMPROMISO,
            $firstIndicator['category']
        );

    }


}