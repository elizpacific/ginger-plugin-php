<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Helpers\HelperTrait;

class ToCamelFromCamelTest extends \PHPUnit\Framework\TestCase
{
    use HelperTrait;

    public function test_dashes_to_camel_case()
    {
        $expected = 'forwardAlwaysMe';
        $real = $this->dashesToCamelCase("forward_always_me");
        self::assertSame($expected, $real);
    }

    public function test_camel_case_to_dashes()
    {
        $expected = 'forward_always_me';
        $real = $this->camelCaseToDashes("forwardAlwaysMe");
        self::assertSame($expected, $real);
    }
}