<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\PaymentMethodDetails;
use PHPUnit\Framework\TestCase;
use TypeError;

class PaymentMethodDetailsTest extends TestCase
{
    private PaymentMethodDetails $payment_method_details;

    public function setUp(): void
    {
        $this->payment_method_details = new PaymentMethodDetails(
            issuer: "test",
            verified_terms: "1"
        );
    }

    public function test_to_array()
    {
        $expected = [
            "issuer" => "test",
            "verified_terms" => "1"
        ];
        self::assertSame(
            $expected,
            $this->payment_method_details->toArray()
        );
    }

    public function test_payment_method_details_for_ideal()
    {
        $expected = [
            'issuer_id' => '123'
        ];
        self::assertSame(
            $expected,
            (new PaymentMethodDetails())->setPaymentMethodDetailsIdeal('123')->toArray()
        );
    }

    public function test_payment_method_details_for_after_pay()
    {
        $expected = [
            'verified_terms_of_service' => true
        ];
        self::assertSame(
            $expected,
            (new PaymentMethodDetails())->setPaymentMethodDetailsAfterPay(true)->toArray()
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->payment_method_details->getPropertyName(),
            'payment_method_details'
        );
    }

    public function test_update_payment_method_details()
    {
        $payment_method_details = OrderStub::getValidPaymentMethodDetails();
        self::assertSame(
            expected: array_replace(
                $payment_method_details->toArray(),
                ['issuer_id' => 555]
            ),
            actual: $payment_method_details->update(issuer_id: 555)->toArray()
        );
    }
}
