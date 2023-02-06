<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\Events;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\Status;
use SebastianBergmann\FileIterator\Facade;


final class Transaction implements MultiFieldsEntityInterface
{
    use HelperTrait, SingleFieldTrait, MultiFieldsEntityTrait;

    protected string $propertyName = '';
    private BaseField $paymentMethod;
    private MultiFieldsEntityInterface $paymentMethodDetails;
    private BaseField $id;
    private BaseField $paymentUrl;
    private BaseField $reason;
    private BaseField $customerMessage;
    private BaseField $isCapturable;
    private BaseField $isFullyCaptured;

    /**
     * @param string $paymentMethod
     * @param PaymentMethodDetails|null $paymentMethodDetails
     * @param string|null $id
     * @param string|null $paymentUrl
     * @param \GingerPluginSdk\Properties\Status|null $status
     * @param string|null $reason
     * @param string|null $customerMessage
     * @param bool|null $isCapturable
     * @param \GingerPluginSdk\Collections\Events|null $events
     * @param bool|null $isFullyCaptured
     * @param mixed ...$additionalProperties
     */
    public function __construct(
        string               $paymentMethod,
        PaymentMethodDetails $paymentMethodDetails = null,
        ?string              $id = null,
        ?string              $paymentUrl = null,
        private ?Status      $status = null,
        ?string              $reason = null,
        ?string              $customerMessage = null,
        ?bool                $isCapturable = null,
        private ?Events      $events = null,
        ?bool                $isFullyCaptured = false,
        mixed                ...$additionalProperties

    )
    {
        $this->paymentMethod = $this->createSimpleField(
            propertyName: 'payment_method',
            value: $paymentMethod
            //TODO: implement schema enum sync-up
        );
        $this->paymentMethodDetails = $paymentMethodDetails ?: new PaymentMethodDetails();

        if ($id) $this->id = $this->createSimpleField(
            'id',
            $id
        );

        if ($paymentUrl) $this->paymentUrl = $this->createSimpleField(
            propertyName: 'payment_url',
            value: $paymentUrl
        );

        if ($reason) $this->reason = $this->createSimpleField(
            propertyName: 'reason',
            value: $reason
        );

        if ($customerMessage) $this->customerMessage = $this->createSimpleField(
            propertyName: 'customer_message',
            value: $customerMessage
        );

        if (isset($isCapturable)) {
            $this->isCapturable = $this->createSimpleField(
                propertyName: 'is_capturable',
                value: $isCapturable
            );
        }

        if ($isFullyCaptured) $this->isFullyCaptured = $this->createSimpleField(
            propertyName: 'is_fully_captured',
            value: $isFullyCaptured
        );

        if ($additionalProperties) $this->filterAdditionalProperties($additionalProperties);
    }

    public function getId(): BaseField|bool
    {
        return $this->id ?? false;
    }

    public function isCapturable(): bool
    {
        if (isset($this->isCapturable)) {
            return $this->isCapturable->get();
        }
        return false;
    }

    public function isCaptured(): bool
    {
        if (isset($this->isFullyCaptured)) {
            return $this->isFullyCaptured->get();
        } else {
            return false;
        }
    }

    public function getPaymentMethodDetails(): PaymentMethodDetails
    {
        return $this->paymentMethodDetails;
    }

    public function getPaymentUrl(): BaseField
    {
        return $this->paymentUrl;
    }

    public function getPaymentMethod(): BaseField
    {
        return $this->paymentMethod;
    }

    public function getReason(): BaseField | null
    {
        return $this->reason;
    }

    public function getCustomerMessage(): BaseField | null
    {
        return $this->customerMessage;
    }
}
