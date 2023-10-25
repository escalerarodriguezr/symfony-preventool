<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Unit\Domain\Admin\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Model\Value\AdminType;

class AdminRoleTest extends TestCase
{
    public function testShouldReturnDomainException()
    {
        self::expectException(\DomainException::class);
        new AdminRole('FAKE_ROLE');
    }

    public function testShouldReturnAdminRoleRoot()
    {
        $adminRole = new AdminRole(AdminRole::ADMIN_ROLE_ROOT);
        self::assertSame($adminRole->value,AdminRole::ADMIN_ROLE_ROOT);
    }

    public function testShouldReturnAdminRoleAdmin()
    {
        $adminRole = new AdminRole(AdminRole::ADMIN_ROLE_ADMIN);
        self::assertSame($adminRole->value,AdminRole::ADMIN_ROLE_ADMIN);
    }

}