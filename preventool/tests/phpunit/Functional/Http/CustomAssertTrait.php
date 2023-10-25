<?php

namespace PHPUnit\Tests\Functional\Http;

use PHPUnit\Framework\TestCase;

trait CustomAssertTrait
{
    protected function assertIsValidUuid(string $uuid, string $message = ''): void
    {
        $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        TestCase::assertMatchesRegularExpression($pattern, $uuid, $message);
    }

}