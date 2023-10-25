<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Unit\Domain\Shared\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\Shared\Model\Value\Uuid;

class UuidTest extends TestCase
{
    const VALID_UUID = 'ee1f6ae7-07af-4692-a103-cef46119ee58';
    const INVALID_UUID = 'invalid';

    public function testShouldReturnUuidWithValidUuidValue(): void
    {

        $uuid = new Uuid(self::VALID_UUID);
        self::assertSame($uuid->value, self::VALID_UUID);
    }

    public function testShouldReturnDomainException(): void
    {
        self::expectException(\DomainException::class);
        new Uuid(self::INVALID_UUID);
    }

}