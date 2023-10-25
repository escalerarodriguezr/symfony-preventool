<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Admin;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivateAdminControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/admin/%s/activate';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class
        ]);
    }

    public function testDeactivateAdmin(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,AdminFixtures::ADMIN_ADMIN_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM admin WHERE id = "%s"',
            AdminFixtures::ADMIN_ADMIN_UUID
        );
        $admin = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(0,$admin['active']);


    }

    public function testActivateAdmin(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $query = sprintf(
            'UPDATE admin SET active = %s WHERE id = "%s"',
            0,
            AdminFixtures::ADMIN_ADMIN_UUID
        );

        self::initDBConnection()->executeQuery($query);

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,AdminFixtures::ADMIN_ADMIN_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM admin WHERE id = "%s"',
            AdminFixtures::ADMIN_ADMIN_UUID
        );
        $admin = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(1,$admin['active']);

    }


}