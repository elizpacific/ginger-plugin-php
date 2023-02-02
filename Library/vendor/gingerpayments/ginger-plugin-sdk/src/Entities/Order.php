<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\Flags;
use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Collections\Transactions;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\Status;

final class Order implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;
    use SingleFieldTrait;

    private BaseField|null $id = null;
    private BaseField|null $webhookUrl = null;
    private BaseField|null $returnUrl = null;
    private BaseField|null $merchantOrderId = null;

    public function __construct(
        private Currency     $currency,
        private Amount       $amount,
        private Transactions $transactions,
        private Customer     $customer,
        private ?OrderLines  $orderLines = null,
        private ?Extra       $extra = null,
        private ?Client      $client = null,
        string               $webhook_url = null,
        string               $return_url = null,
        private ?Flags       $flags = null,
        ?string              $id = null,
        private ?Status      $status = null,
        ?string              $merchantOrderId = null,
        mixed                ...$additionalProperties
    )
    {
        if ($id) $this->id = $this->createSimpleField(
            propertyName: 'id',
            value: $id
        );

        if ($merchantOrderId) $this->merchantOrderId = $this->createSimpleField(
            propertyName: 'merchant_order_id',
            value: $merchantOrderId
        );

        if ($webhook_url) {
            $this->webhookUrl = $this->createSimpleField(
                propertyName: 'webhook_url',
                value: $webhook_url
            );
        }
        if ($return_url) {
            $this->returnUrl = $this->createSimpleField(
                propertyName: 'return_url',
                value: $return_url
            );
        }

        if ($additionalProperties) $this->filterAdditionalProperties($additionalProperties);
    }

    public function getId(): BaseField|null
    {
        return $this->id;
    }

    public function getStatus(): Status|null
    {
        return $this->status;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getOrderLines(): ?OrderLines
    {
        return $this->orderLines;
    }

    public function getMerchantOrderId(): ?BaseField
    {
        return $this->merchantOrderId;
    }

    public function getExtra(): Extra
    {
        return $this->extra;
    }

    public function getCurrentTransaction(): Transaction
    {
        return $this->transactions->get();
    }

    public function getPaymentUrl(): string
    {
        return $this->getCurrentTransaction()->getPaymentUrl()->get();
    }

    //@TODO: Add get order url for pay now payment method.

    public function getWebhookUrl(): BaseField
    {
        return $this->webhookUrl;
    }

    public function getReturnUrl(): BaseField
    {
        return $this->returnUrl;
    }

    public function getFlags() : Flags | null
    {
        return $this->flags;
    }
}