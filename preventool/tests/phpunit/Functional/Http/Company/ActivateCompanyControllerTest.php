<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivateCompanyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/activate';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class
        ]);
    }

    public function testDeactivateCompany(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM company WHERE id = "%s"',
            CompanyFixtures::RIVENDEL_UUID
        );
        $company = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(0,$company['active']);

    }

    public function testActivateCompany(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $query = sprintf(
            'UPDATE company SET active = %s WHERE id = "%s"',
            0,
            CompanyFixtures::RIVENDEL_UUID
        );

        self::initDBConnection()->executeQuery($query);

        self::$authenticatedRootClient->request(
            Request::METHOD_PUT,
            sprintf(self::END_POINT,CompanyFixtures::RIVENDEL_UUID)
        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertSame(Response::HTTP_OK,$response->getStatusCode());

        $query = sprintf(
            'SELECT id, active FROM company WHERE id = "%s"',
            CompanyFixtures::RIVENDEL_UUID
        );
        $company = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertSame(1,$company['active']);

    }


}