<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\ArbitraryArgumentsEntityInterface;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

final class PaymentMethodDetails implements ArbitraryArgumentsEntityInterface, MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;
    use HelperTrait;

    private string $propertyName = 'payment_method_details';
    private BaseField|null $issuer_id = null;
    private BaseField|null $verified_terms_of_service = null;

    /**
     * @param string|array ...$attributes
     */
    public function __construct(...$attributes)
    {
        if (!$this->isAssoc($attributes)) {
            foreach ($attributes as $attribute) {
                foreach ($attribute as $title => $value) {
                    $this->$title = $this->createSimpleField(
                        propertyName: $this->camelCaseToDashes($title),
                        value: $value
                    );
                }
            }
        } else {
            foreach ($attributes as $title => $value) {
                $this->$title = $this->createSimpleField(
                    propertyName: $this->camelCaseToDashes($title),
                    value: $value
                );
            }
        }
    }

    /**
     * Set Payment Method Details for Ideal payment method.
     *
     * @param string $issuer
     * @return $this
     */
    public function setPaymentMethodDetailsIdeal(string $issuer): PaymentMethodDetails
    {
        $this->issuer_id = $this->createSimpleField(
            propertyName: 'issuer_id',
            value: $issuer
        );
        return $this;
    }

    /**
     * Set Payment Method Details for AfterPay payment method.
     *
     * @param bool $verifiedTerms
     * @return $this
     */
    public function setPaymentMethodDetailsAfterPay(bool $verifiedTerms): PaymentMethodDetails
    {
        $this->verified_terms_of_service = $this->createSimpleField(
            propertyName: 'verified_terms_of_service',
            value: $verifiedTerms
        );
        return $this;
    }
}