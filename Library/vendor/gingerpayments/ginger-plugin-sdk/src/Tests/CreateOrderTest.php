<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Collections\AdditionalAddresses;
use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Collections\PhoneNumbers;
use GingerPluginSdk\Collections\Transactions;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Exceptions\APIException;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\EmailAddress;
use GingerPluginSdk\Properties\Locale;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{
    private Order $order;
    private \GingerPluginSdk\Client $client;

    public function setUp(): void
    {
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
        $this->order = OrderStub::getValidOrder();
    }

    public function test_method_get_id()
    {
        $order_with_id_property = Client::fromArray(
            Order::class,
            array_merge(
                $this->order->toArray(),
                ['id' => 'id123']
            )
        );
        self::assertSame(
            expected: 'id123',
            actual: $order_with_id_property->getId()->get()
        );
    }


    public function test_method_get_empty_id()
    {
        self::assertNull(
            OrderStub::getValidOrder()->getId()?->get()
        );
    }

    public function test_method_get_false_status()
    {
        self::assertNull(
            OrderStub::getValidOrder()->getStatus()?->get()
        );
    }

    /**
     * @throws \Exception
     */
    public function test_method_get_status()
    {
        $order_with_status_property = Client::fromArray(
            Order::class,
            array_merge(
                $this->order->toArray(),
                ['status' => 'processing']
            )
        );
        self::assertSame(
            expected: 'processing',
            actual: $order_with_status_property->getStatus()->get()
        );
    }

    /**
     * @throws \Exception
     */
    public function test_method_get_flags()
    {
        $order_with_flags = Client::fromArray(
            Order::class,
            array_merge(
                $this->order->toArray(),
                    ['flags' => [
                        'is-test',
                        'has-refund'
                    ]
                ]
            )
        );

        self::assertSame(
            expected: [
                'is-test',
                'has-refund'
            ],
            actual: $order_with_flags->getFlags()->getAll()
        );
    }

    public function test_method_get_current_transaction()
    {
        self::assertSame(
            expected: OrderStub::getValidTransaction()->toArray(),
            actual: $this->order->getCurrentTransaction()->toArray()
        );
    }

    /**
     * @throws \Exception
     */
    public function test_sending()
    {
        $this->client = new \GingerPluginSdk\Client(
            new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY'))
        );
        $response = $this->client->sendOrder($this->order);
        self::assertSame($response->getStatus()?->get(), 'new');
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->order->getPropertyName(),
            ''
        );
    }

    public function test_exception_validation_ideal()
    {
        $this->client = new \GingerPluginSdk\Client(
            new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY'))
        );
        self::expectException(APIException::class);
        $test_order = new Order(
            currency: new Currency('NUL'),
            amount: new Amount(500),
            transactions: OrderStub::getValidTransactions(),
            customer: OrderStub::getValidCustomer(),
            orderLines: OrderStub::getValidOrderLines(),
            description: 'Test Product',
            extra: new Extra(
                ['sw_order_id' => 501]
            ),
            client: OrderStub::getValidClient()
        );
        $response = $this->client->sendOrder($test_order);
    }

    public function test_exception_validation_afterpay()
    {
        $this->client = new \GingerPluginSdk\Client(
            new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY'))
        );
        self::expectException(APIException::class);
        $test_order = new Order(
            currency: new Currency('NUL'),
            amount: new Amount(500),
            transactions: new Transactions(
                new Transaction(
                    paymentMethod: 'credit-card',
                    paymentMethodDetails: new PaymentMethodDetails(
                        issuer_id: "15",
                        verified_terms_of_service: true
                    )
                )
            ),
            customer: OrderStub::getValidCustomer(),
            orderLines: OrderStub::getValidOrderLines(),
            description: 'Test Product',
            extra: new Extra(
                ['sw_order_id' => 501]
            ),
            client: OrderStub::getValidClient()
        );
        $response = $this->client->sendOrder($test_order);
    }
}