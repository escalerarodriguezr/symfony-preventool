<?php
declare(strict_types=1);

namespace App\Tests\phpunit\Unit\Infrastructure\Ui\Http\Service\IdentityValidator;

use PHPUnit\Framework\TestCase;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Service\IdentityValidator\HttpIdentityValidator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HttpIdentityValidatorTest extends TestCase
{
    private IdentityValidator $identityValidator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->identityValidator = new HttpIdentityValidator();
    }


    public function testShouldReturnVoidWhenIdentityIsValidId()
    {
        $this->identityValidator->validate('b56cbbb4-4065-4d87-baf0-345f0adcaf10');
        self::assertTrue(true);
    }

    public function testShouldThrowExceptionWhenIdentityIsInvalidId()
    {
        self::expectException(BadRequestHttpException::class);
        $this->identityValidator->validate('fake-id');
    }


}