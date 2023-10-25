<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\HealthCheck;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class HealthCheckTest extends FunctionalHttpTestBase
{
    public function setUp():void
    {
        parent::setUp();
    }

    private function prepareDataBase():void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class
        ]);
    }

    public function testBaseClient(): void
    {
        $this->baseClient();
        self::assertInstanceOf(KernelBrowser::class, self::$baseClient);
    }

    public function testAuthenticateRootClient(): void
    {
        $this->prepareDataBase();
        $this->authenticatedRootClient();
        self::assertInstanceOf(KernelBrowser::class, self::$authenticatedRootClient);
    }

}