<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Bases\BaseField;

use PHPUnit\Framework\TestCase;

class BaseFieldTest extends TestCase
{
    private $field;

    public function setUp(): void
    {
        $this->field = new class extends BaseField {
             public function __construct()
            {
                $propertyName = 'test_property';
                parent::__construct($propertyName);
            }
        };
        $this->field->set('test');
    }

    public function test_valid_base_field_value_test()
    {
        $expected = 'test';
        self::assertSame(
            $expected,
            $this->field->get()
        );
    }


    public function test_valid_base_field_property_test()
    {
        $expected = 'test_property';
        self::assertSame(
            $expected,
            $this->field->getPropertyName()
        );
    }
}

