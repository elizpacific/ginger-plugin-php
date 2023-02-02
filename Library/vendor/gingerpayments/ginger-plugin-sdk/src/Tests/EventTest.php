<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Event;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Money;
use GingerPluginSdk\Properties\RawCost;

class EventTest extends \PHPUnit\Framework\TestCase
{
    public function test_valid_event()
    {
        $event = new Event(
            event: 'new',
            occurred: '2022-05-17T11:58:33.813534+00:00',
            source: 'google',
            noticed: '2022-05-17T11:58:33.813534+00:00',
            id: '123'
        );
        self::assertSame(
            expected: $event::class,
            actual: Event::class
        );;
    }

    public function test_to_array()
    {
        $expected = [
            "event" => 'new',
            'occurred' => '2022-05-17T11:58:33.813534+00:00',
            'noticed' => '2022-05-17T11:58:33.813534+00:00',
            'id' => '123',
            'source' => '123'
        ];
        $real = new Event(
            occurred: '2022-05-17T11:58:33.813534+00:00',
            event: 'new',
            source: '123',
            noticed: '2022-05-17T11:58:33.813534+00:00',
            id: '123'
        );
        self::assertEqualsCanonicalizing(
            expected: $expected,
            actual: $real->toArray()
        );
    }

    public function test_get_property_name()
    {
        self::assertSame(
            expected: '',
            actual: (new Event(
                event: 'capturing', orccured: '2022-05-17T11:58:33.813534+00:00')
            )->getPropertyName()
        );
    }

    public function test_minimal_additional_properties()
    {
        self::assertEqualsCanonicalizing(
            expected: [
                "event" => 'new',
                'occurred' => '2022-05-17T11:58:33.813534+00:00',
                'noticed' => '2022-05-17T11:58:33.813534+00:00',
                'id' => '123',
                'source' => '123',
                "amount" => 30
            ],
            actual: (new Event(
                event: 'new',
                occurred: '2022-05-17T11:58:33.813534+00:00',
                source: '123',
                noticed: '2022-05-17T11:58:33.813534+00:00',
                id: '123',
                amount: new Amount(new RawCost(0.30))
            ))->toArray()
        );
    }

    public function test_from_live_additional_properties()
    {
        $expected = [
            "calculation_type" => "blended",
            "currency" => "EUR",
            "event" => "registered_billing_fees",
            "id" => "6ed05ed3-67b9-406f-9f92-f29d92d86a64",
            "noticed" => "2022-06-03T11:14:04.704286+00:00",
            "occurred" => "2022-06-03T11:14:04.704292+00:00",
            "payout_system" => "gross",
            "transaction_fee" => 0,
            "vat_amount" => 0,
            "vat_class" => "nl-high",
            "vat_percentage" => 21
        ];
        sort($expected);

        $actual = (new Event(
            event: "registered_billing_fees",
            occurred: "2022-06-03T11:14:04.704292+00:00",
            noticed: "2022-06-03T11:14:04.704286+00:00",
            id: "6ed05ed3-67b9-406f-9f92-f29d92d86a64",
            payoutSystem: "gross",
            transactionFee: 0,
            vatAmount: 0,
            vatClass: "nl-high",
            vatPercentage: 21,
            calculationType: 'blended',
            currency: "EUR",
        ))->toArray();

        sort($actual);
        self::assertEqualsCanonicalizing(
            expected: $expected,
            actual: $actual
        );
    }
}