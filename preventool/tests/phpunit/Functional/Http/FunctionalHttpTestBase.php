<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http;

use Doctrine\DBAL\Connection;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Preventool\Domain\User\Repository\UserRepository;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalHttpTestBase extends WebTestCase
{
    use CustomAssertTrait;

    private static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $baseClient = null;
    protected static ?KernelBrowser $authenticatedRootClient = null;
    protected static ?KernelBrowser $authenticatedAdminClient = null;

    protected mixed $databaseTool;


    public function setUp():void
    {
        parent::setUp();
        $this->getClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    protected function getClient():void
    {
        self::$client = null;
        if (null === self::$client) {
            self::$client = static::createClient();
        }
    }

    protected function baseClient():void
    {
        self::$baseClient = null;
        if (null === self::$baseClient) {
            self::$baseClient = clone self::$client;
            self::$baseClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ]);
        }
    }

    protected static function initDBConnection(): Connection
    {
        if (null === static::$kernel) {
            static ::bootKernel();
        }

        return static::$kernel->getContainer()->get('doctrine')->getConnection();
    }

    protected function authenticatedRootClient():void
    {
        self::$authenticatedRootClient = null;
        if (null === self::$authenticatedRootClient) {
            self::$authenticatedRootClient = clone self::$client;

            $user = static::getContainer()->get(UserRepository::class)->findByEmail(UserFixtures::ROOT_EMAIL);
            $token = static::getContainer()->get(JWTTokenManagerInterface::class)->create($user);

            self::$authenticatedRootClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
            ]);
        }
    }

    protected function authenticatedAdminClient():void
    {
        self::$authenticatedAdminClient = null;
        if (null === self::$authenticatedAdminClient) {
            self::$authenticatedAdminClient = clone self::$client;

            $user = static::getContainer()->get(UserRepository::class)->findByEmail(UserFixtures::ADMIN_EMAIL);
            $token = static::getContainer()->get(JWTTokenManagerInterface::class)->create($user);

            self::$authenticatedAdminClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
            ]);
        }
    }

}