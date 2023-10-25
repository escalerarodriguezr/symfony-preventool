<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Workplace;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\WorkplaceFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteWorkplaceControllerTest extends FunctionalHttpTestBase
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

    public function testDeleteWorkplaceControllerSuccessResponse(): void
    {
        $this->prepareDataBase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_DELETE,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
            )
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }

    public function testDeleteWorkplaceControllerByAdminRoleSuccessResponse(): void
    {
        $this->prepareDataBase();
        $this->authenticatedAdminClient();

        self::$authenticatedAdminClient->request(
            Request::METHOD_DELETE,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID,
                WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
            )
        );

        $response = self::$authenticatedAdminClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());
    }


}