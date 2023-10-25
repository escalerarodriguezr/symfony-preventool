<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Unit\Domain\Admin\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\Admin\Model\Value\AdminType;

class AdminTypeTest extends TestCase
{
    public function testShouldReturnDomainException()
    {
        self::expectException(\DomainException::class);
        new AdminType('FAKE_TYPE');
    }

    public function testShouldReturnAdminTypeWithValidType()
    {
        $adminType = new AdminType(AdminType::ADMIN_TYPE_ADMIN);
        self::assertSame($adminType->value,AdminType::ADMIN_TYPE_ADMIN);
    }

}