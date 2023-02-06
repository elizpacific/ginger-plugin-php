<?php

declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Locale;
use GingerPluginSdk\Properties\Percentage;
use GingerPluginSdk\Properties\RawCost;
use GingerPluginSdk\Properties\VatPercentage;
use PHPUnit\Framework\TestCase;

class OrderLinesTest extends TestCase
{
    private OrderLines $order_lines;

    public function setUp(): void
    {
        $this->order_lines = new OrderLines(
            new Line(
                type: 'physical',
                merchantOrderLineId: '0',
                name: 'Milk',
                quantity: 1,
                amount: new Amount(new RawCost(50.50)),
                vatPercentage: new VatPercentage(new Percentage(25))
            ),
            new Line(
                type: 'shipping_fee',
                merchantOrderLineId: '0',
                name: 'Fly',
                quantity: 1,
                amount: new Amount(new RawCost(50.5)),
                vatPercentage: new VatPercentage(new Percentage(25))
            ),

        );
    }

    public function test_invalid_type_line()
    {
        self::expectException(\TypeError::class);
        $test = new OrderLines(
            new Locale(
                'NL_be'
            )
        );
    }

    public function test_to_array()
    {
        $expected_array = [
            [
                'type' => 'physical',
                'name' => 'Milk',
                'quantity' => 1,
                'amount' => 5050,
                'vat_percentage' => 2500,
                'merchant_order_line_id' => "0"
            ],
            [
                'type' => 'shipping_fee',
                'name' => 'Fly',
                'quantity' => 1,
                'amount' => 5050,
                'vat_percentage' => 2500,
                'merchant_order_line_id' => "0"
            ]
        ];
        $real = $this->order_lines->toArray();
        self::assertEqualsCanonicalizing(
            expected: $expected_array,
            actual: $real
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->order_lines->getPropertyName(),
            'order_lines'
        );
    }

    public function test_add_line()
    {
        $lines = new OrderLines();
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '666',
            name: 'Quilvier',
            quantity: 5001,
            amount: new Amount(new RawCost(2.50))
        );
        self::assertEqualsCanonicalizing(
            expected: [
                'type' => 'physical',
                'merchant_order_line_id' => '666',
                'name' => 'Quilvier',
                'quantity' => 5001,
                'amount' => 250
            ],
            actual: $lines->addLine(item: $line)->get()->toArray()
        );
    }

    public function test_remove_line()
    {
        $lines = new OrderLines(new Line(
            type: 'physical',
            merchantOrderLineId: '666',
            name: 'Quilvier',
            quantity: 5001,
            amount: new Amount(new RawCost(2.50))
        ));

        self::assertEqualsCanonicalizing(
            expected: [],
            actual: $lines->removeLine(0)->getAll()
        );
    }
}
