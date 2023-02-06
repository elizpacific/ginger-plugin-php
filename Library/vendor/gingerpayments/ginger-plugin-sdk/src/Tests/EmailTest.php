<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\EmailAddress;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_allow_valid_email()
    {
        $expected = 'test@mail.ginger';
        $real = new EmailAddress('test@mail.ginger');
        self::assertSame($expected, $real->get());
    }

    public function test_disallow_invalid_email()
    {
        self::expectException(OutOfPatternException::class);
        $test = new EmailAddress('Netherlands');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new EmailAddress("nanallew@dota.com"))->getPropertyName(),
            'email_address'
        );
    }
}
