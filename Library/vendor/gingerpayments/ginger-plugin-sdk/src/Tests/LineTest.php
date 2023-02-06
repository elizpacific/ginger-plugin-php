<?php

declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\Percentage;
use GingerPluginSdk\Properties\RawCost;
use GingerPluginSdk\Properties\VatPercentage;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    private Line $line;

    public function setUp(): void
    {
        $this->line = new Line(
            type: 'physical',
            merchantOrderLineId: '1',
            name: 'Bottle',
            quantity: 3,
            amount: new Amount(new RawCost(664)),
            vatPercentage: new VatPercentage(new Percentage(25))
        );
    }

    public function test_valid_line()
    {
        $expected_array = [
            'type' => 'physical',
            'merchant_order_line_id' => '1',
            'name' => 'Bottle',
            'quantity' => 3,
            'amount' => 66400,
            'vat_percentage' => 2500
        ];
        self::assertEqualsCanonicalizing($expected_array, $this->line->toArray());
    }

    public function test_invalid_enum_for_type()
    {
        self::expectException(OutOfEnumException::class);
        $test = new Line(
            type: 'magical',
            merchantOrderLineId: '1',
            name: 'Bottle',
            quantity: 3,
            amount: new Amount(664),
            vatPercentage: new VatPercentage(new Percentage(25))
        );
    }

    public function test_set_discount_rate()
    {
        $expected = 1500;
        self::assertSame(
            $expected,
            $this->line->setDiscountRate(15)->getDiscountRate());
    }

    public function test_discount_rate_out_of_diapason()
    {
        self::expectException(OutOfDiapasonException::class);
        $this->line->setDiscountRate(101);
    }

    public function test_set_url()
    {
        $expected = 'programminghub.com/pc.png';
        self::assertSame(
            $expected,
            $this->line->setUrl('programminghub.com/pc.png')->getUrl()
        );
    }

    public function test_vat_percentage_out_of_diapason()
    {
        self::expectException(OutOfDiapasonException::class);
        $test = new Line(
            type: "discount",
            merchantOrderLineId: '5',
            name: 'Home',
            quantity: 1,
            amount: new Amount(5),
            vatPercentage: new VatPercentage(new Percentage(110)),
        );
    }

    public function test_quantity_out_of_diapason()
    {
        self::expectException(OutOfDiapasonException::class);
        $test = new Line(
            type: "discount",
            merchantOrderLineId: '5',
            name: 'Home',
            quantity: 0,
            amount: new Amount(5),
            vatPercentage: new VatPercentage(new Percentage(20)),
        );
    }

    public function test_currency_field_type()
    {
        self::expectException(\TypeError::class);
        $test = new Line(
            type: 'physical',
            merchantOrderLineId: '1',
            name: 'Banc',
            quantity: 5,
            amount: new Amount(11.25),
            vatPercentage: 0,
            currency: 'EUR'
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->line->getPropertyName(),
            ""
        );
    }

    public function test_vat_percentage()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '1',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1)
        );
        self::assertSame(
            expected: null,
            actual: $line->getVatPercentage()
        );
    }

    public function test_currency()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '1',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1),
            currency: new Currency('EUR')
        );
        self::assertSame(
            expected: "EUR",
            actual: $line->getCurrency()->get()
        );
    }

    public function test_merchant_order_line_id()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '121',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1),
            currency: new Currency('EUR')
        );
        self::assertSame(
            expected: "121",
            actual: $line->getMerchantOrderLineId()->get()
        );
    }

    public function test_get_name()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '121',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1),
            currency: new Currency('EUR')
        );
        self::assertSame(
            expected: "exel",
            actual: $line->getName()->get()
        );
    }

    public function test_get_quantity()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '121',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1),
            currency: new Currency('EUR')
        );
        self::assertSame(
            expected: 1,
            actual: $line->getQuantity()->get()
        );
    }

    public function test_get_type()
    {
        $line = new Line(
            type: 'physical',
            merchantOrderLineId: '121',
            name: 'exel',
            quantity: 1,
            amount: new Amount(1),
            currency: new Currency('EUR')
        );
        self::assertSame(
            expected: "physical",
            actual: $line->getType()->get()
        );
    }
}
