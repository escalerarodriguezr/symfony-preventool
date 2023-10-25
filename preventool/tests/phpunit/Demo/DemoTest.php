<?php
declare(strict_types=1);

namespace App\Tests\phpunit\Demo;

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function testCheck()
    {
        $t=2;
        self::assertSame(1,1);

    }


}