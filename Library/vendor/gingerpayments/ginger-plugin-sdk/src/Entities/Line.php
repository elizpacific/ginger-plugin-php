<?php

namespace GingerPluginSdk\Entities;

use Exception;
use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\VatPercentage;


final class Line implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private BaseField $type;
    private BaseField $merchantOrderLineId;
    private BaseField $name;
    private BaseField $quantity;
    private BaseField $discountRate;
    private BaseField $url;

    /**
     * @param string $type - Type: physical, discount, shipping_fee, sales_tax, digital, gift_card, store_credit or surcharge
     * @param string $merchantOrderLineId - Merchant's internal order line identifier
     * @param string $name - Name, usually a short description
     * @param int $quantity
     * @param \GingerPluginSdk\Properties\Amount $amount - Amount for a single item (including VAT) in cents
     * @param \GingerPluginSdk\Properties\VatPercentage|null $vatPercentage - Percentage of tax rate, will be multiplied by 100 and provided as an integer. i.e. 17.50% would be sent as 1750
     * @param Currency|null $currency
     * @param int|null $discountRate - Percentage of discount, will be multiplied by 100 and provided as an integer. i.e. 11.57% would be sent as 1157
     * @param string|null $url - Item product page URI
     */
    public function __construct(
        string                 $type,
        string                 $merchantOrderLineId,
        string                 $name,
        int                    $quantity,
        private Amount         $amount,
        private ?VatPercentage $vatPercentage = null,
        private ?Currency      $currency = null,
        ?int                   $discountRate = null,
        ?string                $url = null
    )
    {
        $this->type = $this->createEnumeratedField(
            propertyName: 'type',
            value: $type,
            enum: [
                "physical",
                "discount",
                "shipping_fee",
                "sales_tax",
                "digital",
                "gift_card",
                "store_credit",
                "surcharge"
            ]
        );
        $this->merchantOrderLineId = $this->createSimpleField(
            propertyName: 'merchant_order_line_id',
            value: $merchantOrderLineId
        );
        $this->name = $this->createSimpleField(
            propertyName: 'name',
            value: $name
        );

        $this->quantity = $this->createFieldWithDiapasonOfValues(
            propertyName: 'quantity',
            value: $quantity,
            min: 1
        );

        if ($discountRate) $this->setDiscountRate($discountRate);
        if ($url) $this->setUrl($url);
    }

    public function getUrl(): ?string
    {
        return $this->url->get();
    }

    public function getVatPercentage(): ?BaseField
    {
        return $this->vatPercentage;
    }

    public function getDiscountRate(): ?int
    {
        return $this->discountRate->get();
    }

    public function getAmount(): int
    {
        return $this->amount->get();
    }

    public function getCurrency(): ?    BaseField
    {
        return $this->currency;
    }

    public function getMerchantOrderLineId(): BaseField
    {
        return $this->merchantOrderLineId;
    }

    public function getName(): BaseField
    {
        return $this->name;
    }

    public function getQuantity(): BaseField
    {
        return $this->quantity;
    }

    public function getType(): BaseField
    {
        return $this->type;
    }

    /**
     * @param string|null $url
     * @return $this
     */
    public function setUrl(?string $url): Line
    {
        $this->url = $this->createSimpleField(
            propertyName: 'url',
            value: $url
        );
        return $this;
    }

    /**
     * @param int|null $value
     * @return $this
     */
    public function setDiscountRate(?int $value): Line
    {
        $this->discountRate = $this->createFieldWithDiapasonOfValues(
            propertyName: 'discount_rate',
            value: $this->calculateValueInCents($value),
            min: 0, max: 10000
        );
        return $this;
    }
}