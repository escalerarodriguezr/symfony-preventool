<?php
declare(strict_types=1);

namespace App\Tests\phpunit\Unit\Domain\User\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\User\Model\Value\UserRole;

class UserRoleTest extends TestCase
{
    public function testShouldReturnDomainExceptionWithInvalidUserRole()
    {
        self::expectException(\DomainException::class);
        new UserRole('FAKE_ROLE');
    }

    public function testShouldReturnDomainRoleWithValidUserRole()
    {
        $userRole = new UserRole(UserRole::USER_ROLE_ADMIN);
        self::assertSame($userRole->value,UserRole::USER_ROLE_ADMIN);
    }

}