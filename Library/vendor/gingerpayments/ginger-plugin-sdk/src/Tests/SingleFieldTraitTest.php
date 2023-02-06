<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use PHPUnit\Framework\TestCase;

class SingleFieldTraitTest extends TestCase
{
    use SingleFieldTrait;

    public function test_valid_single_field_creation()
    {
        $actual = $this->createSimpleField('test_property','test_value');

        self::assertInstanceOf(
            BaseField::class,
            $actual
        );

        self::assertSame(
            'test_value',
            $actual->get()
        );

        self::assertSame(
            'test_property',
            $actual->getPropertyName()
        );
    }
}
