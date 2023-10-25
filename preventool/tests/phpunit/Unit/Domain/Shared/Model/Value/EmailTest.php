<?php
declare(strict_types=1);

namespace App\Tests\phpunit\Unit\Domain\Shared\Model\Value;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\Shared\Model\Value\Email;

class EmailTest extends TestCase
{
    public function testShouldReturnDomainExceptionWithEmptyValue(): void
    {
        self::expectException(\DomainException::class);
        new Email('');
    }

    public function testShouldReturnDomainExceptionWithInvalidEmailValue(): void
    {
        self::expectException(\DomainException::class);
        new Email('fake@fake');
    }

    public function testShouldReturnEmailWithValidEmailValue(): void
    {

        $email = new Email('fake@fake.com');
        self::assertSame($email->value, 'fake@fake.com');
    }

}