<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Tests\OrderStub;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Framework\TestCase;

class MultiFieldsEntityTraitTest extends TestCase
{
    public function test_additional_additional_properties()
    {
        $object = new Mocked(
            sample_property: '123',
            another_property: '321'
        );
        self::assertSame(
            expected: [
                'sample_property' => '123',
                'another_property' => '321'
            ],
            actual: $object->toArray()
        );
    }

    public function test_additional_additional_property_currency()
    {
        $object = new Mocked(
            sample_property: 'EEE',
            currency: 'EUR'
        );
        self::assertSame(
            expected: [
                'sample_property' => 'EEE',
                'currency' => 'EUR'
            ],
            actual: $object->toArray()
        );
    }

    public function test_filter_additional_property_order_lines()
    {
        $object = new Mocked(
            sample_property: 'A',
            order_lines: [
                OrderStub::getValidLine()
            ]
        );
        self::assertSame(
            expected: [
                'sample_property' => 'A',
                'order_lines' => [
                    OrderStub::getValidLine()->toArray()
                ]
            ],
            actual: $object->toArray()
        );
    }
}

class Mocked
{
    use MultiFieldsEntityTrait, SingleFieldTrait;

    private BaseField $sample_property;

    public function __construct(
        string $sample_property,
        mixed  ...$additionalProperties
    )
    {
        $this->sample_property = $this->createSimpleField(
            propertyName: 'sample_property',
            value: $sample_property
        );

        if ($additionalProperties) $this->filterAdditionalProperties($additionalProperties);
    }
}