<?php

namespace GingerPluginSdk\Entities;

use Cassandra\Date;
use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Collections\AdditionalAddresses;
use GingerPluginSdk\Collections\PhoneNumbers;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Birthdate;
use GingerPluginSdk\Properties\EmailAddress;
use GingerPluginSdk\Properties\Locale;


final class Customer implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;
    use SingleFieldTrait;

    private string $propertyName = 'customer';

    private BaseField $lastName;
    private BaseField $firstName;
    private BaseField|null $gender;
    private BaseField $address;
    private BaseField $addressType;
    private Country $country;
    private BaseField $postalCode;
    private BaseField $houseNumber;
    private PhoneNumbers|null $phoneNumbers = null;
    private BaseField|null $merchantCustomerId = null;
    private BaseField|null $ipAddress = null;

    /**
     * @param \GingerPluginSdk\Collections\AdditionalAddresses $additionalAddresses
     * @param string $firstName
     * @param string $lastName
     * @param EmailAddress $emailAddress
     * @param string|null $gender - Customer's gender
     * @param PhoneNumbers|null $phoneNumbers
     * @param \GingerPluginSdk\Properties\Birthdate|null $birthdate - Customer's birthdate (ISO 8601 / RFC 3339)
     * @param \GingerPluginSdk\Properties\Country|null $country
     * @param string|null $ipAddress
     * @param string|null $addressType
     * @param mixed ...$additionalProperties
     */
    public function __construct(
        private AdditionalAddresses $additionalAddresses,
        string                      $firstName,
        string                      $lastName,
        private EmailAddress        $emailAddress,
        ?string                     $gender = null,
        ?PhoneNumbers               $phoneNumbers = null,
        private ?Birthdate          $birthdate = null,
        ?Country                    $country = null,
        ?string                     $ipAddress = null,
        ?string                     $addressType = null,
        private ?Locale             $locale = null,
        ?string                     $merchantCustomerId = null,
        mixed                       ...$additionalProperties
    )
    {
        $this->firstName = $this->createSimpleField(
            propertyName: 'first_name',
            value: $firstName
        );

        $this->lastName = $this->createSimpleField(
            propertyName: 'last_name',
            value: $lastName
        );

        $this->country = $country ?? new Country(
                $this->additionalAddresses->get()->getCountry()->get()
            );

        if ($addressType) {
            $this->addressType = $this->createSimpleField(
            //TODO: add schema enum validation
                propertyName: 'address_type',
                value: $addressType,
            );
        }


        if ($gender) {
            $this->gender = $this->createEnumeratedField(
                propertyName: 'gender',
                value: $gender,
                enum: [
                    'male', 'female'
                ]
            );
        }
        if ($merchantCustomerId) {
            $this->merchantCustomerId = $this->createSimpleField(
                propertyName: 'merchant_customer_id',
                value: $merchantCustomerId
            );
        }

        if ($additionalProperties) $this->filterAdditionalProperties($additionalProperties);

        if ($phoneNumbers) $this->setPhoneNumbers($phoneNumbers);
        $this->setIpAddress($ipAddress);
    }

    public function getFirstName(): BaseField
    {
        return $this->firstName;
    }

    public function getLastName(): BaseField
    {
        return $this->lastName;
    }

    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function getAdditionalAddress(): AdditionalAddresses
    {
        return $this->additionalAddresses;
    }

    public function getBirthdate(): Birthdate
    {
        return $this->birthdate;
    }

    public function getGender(): BaseField|null
    {
        return $this->gender;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getIpAddress(): BaseField
    {
        return $this->ipAddress;
    }

    public function getMerchantCustomerId(): BaseField
    {
        return $this->merchantCustomerId;
    }

    public function getPhoneNumbers(): PhoneNumbers
    {
        return $this->phoneNumbers;
    }

    /**
     * @return $this
     */
    public function setIpAddress($ipAddress = null): Customer
    {
        $this->ipAddress = $this->createSimpleField(
            propertyName: "ip_address",
            value: $ipAddress ?? $_SERVER['REMOTE_ADDR']
        );
        return $this;
    }


    /**
     * @param PhoneNumbers $phoneNumbers
     * @return Customer
     */
    public function setPhoneNumbers(PhoneNumbers $phoneNumbers): Customer
    {
        $this->phoneNumbers = $phoneNumbers;
        return $this;
    }
}