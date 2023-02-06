<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\Transactions;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Properties\Locale;
use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase
{
    private Transactions $transactions;

    public function setUp(): void
    {
        $this->transactions = new Transactions(
            new Transaction(
                paymentMethod: 'ideal',
                paymentMethodDetails: new PaymentMethodDetails(
                    issuer_id: "15"
                )
            )
        );
    }

    public function test_to_array()
    {
        $expected = [
            [
                'payment_method' => 'ideal',
                'payment_method_details' => [
                    'issuer_id' => "15"
                ]
            ]
        ];
        self::assertSame(
            $expected,
            $this->transactions->toArray()
        );
    }

    public function test_invalid_constructor_item_type()
    {
        self::expectException(\TypeError::class);
        $test = new Transactions(
            new Locale("NL_nl")
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->transactions->getPropertyName(),
            'transactions'
        );
    }

    public function test_update_transactions()
    {
        $transactions = OrderStub::getValidTransactions();
        $transactions->updateTransaction(
            transaction: OrderStub::getValidTransaction()->update(payment_method: '999')
        );
        self::assertSame(
            expected: '999',
            actual: $transactions->get()->getPaymentMethod()->get()
        );

    }

    public function test_add_transaction()
    {
        $transactions = OrderStub::getValidTransactions();
        $transactions->addTransaction(new Transaction(
            paymentMethod: 'amex'
        ));
        self::assertSame(
            expected: 'amex',
            actual: $transactions->get(1)->getPaymentMethod()->get()
        );
    }

    public function test_remove_transaction()
    {
        $transactions = OrderStub::getValidTransactions();
        $transactions->addTransaction(new Transaction(
            paymentMethod: 'amex'
        ));
        self::assertSame(
            expected: 2,
            actual: $transactions->count()
        );
        $transactions->removeTransaction(0);
        self::assertSame(
            expected: 'amex',
            actual: $transactions->get()->getPaymentMethod()->get()
        );
        self::assertSame(
            expected: 1,
            actual: $transactions->count()
        );
    }

    public function test_create_transactions_without_payment_method_details()
    {
        $transactions = new Transactions(new Transaction('next.js'));
        self::assertEqualsCanonicalizing(
            expected: [
                [
                    'payment_method' => 'next.js'
                ]
            ],
            actual: $transactions->toArray()
        );
    }
}
