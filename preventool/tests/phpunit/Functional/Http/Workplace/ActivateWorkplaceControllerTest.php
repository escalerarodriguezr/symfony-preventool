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

class ActivateWorkplaceControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/workplace/%s/activate';

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

    public function testDeactivateWorkplace(): void
    {
        $this->prepareDataBase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM workplace WHERE id = "%s"',
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
        );
        $workplace = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(0,$workplace['active']);

    }

    public function testActivateWorkplace(): void
    {
        $this->prepareDataBase();
        $this->authenticatedRootClient();

        $query = sprintf(
            'UPDATE workplace SET active = %s WHERE id = "%s"',
            0,
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
        );

        self::initDBConnection()->executeQuery($query);

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM workplace WHERE id = "%s"',
            WorkplaceFixtures::RIVENDEL_WORKPLACE_1_UUID
        );
        $workplace = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(1,$workplace['active']);

    }


}