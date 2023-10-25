<?php
declare(strict_types=1);

namespace App\Tests\phpunit\Unit\Domain\User\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\User\Model\Value\UserPassword;

class UserPasswordTest extends TestCase
{
    public function testShouldReturnDomainExceptionWithInvalidMinLength()
    {
        self::expectException(\DomainException::class);
        new UserPassword("fake");

    }

    public function testShouldReturnDomainExceptionWithEmptyValue()
    {
        self::expectException(\DomainException::class);
        new UserPassword("");
    }

    public function testShouldReturnUserPasswordWithValidValue()
    {
        $password = new UserPassword("qwertyuiop");
        self::assertSame($password->value,'qwertyuiop');
    }


}