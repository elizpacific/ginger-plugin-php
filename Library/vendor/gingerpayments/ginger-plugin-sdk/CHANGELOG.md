# 1.0.0

Initial version

## 1.1.0

* Implemented `fromArray` method.
* Implemented CHANGELOG.
* Implemented `FromArrayTest`.
* Implemented `dashToCamelCase` and `camelCaseToDash` method to support field name parsing.
* Implemented `ToCamelFromCamelTest`
* Implemented `ArbitraryArgumentsEntityInterface` to handle entities with dynamic constructor options list.
* Implemented new properties for `Transaction` entity :
    * id
    * merchant_id
    * created
    * modified
    * settled
    * finalized
    * completed
    * expiration_period
    * currency,
    * amount,
    * balance,
    * description,
    * product_type,
    * status,
    * reason,
    * isCapturable,
    * orderId,
    * channel,
    * projectType
    * flags
    * events
        * event
            * occurred
            * noticed
            * source
            * id
            * event
* Implemented `EventsTest`.
* Implemented `EventTest`.
* Implemented `GetOrderTest`.
* Implemented `test_customer_from_api_array` to `FromArrayTest`.
* Implemented `OrderCreationFailedException`
* Implemented `Status` Property
* Implemented `StatusTest`
* Implemented `createFieldInDateTimeISO8601` method into `SingleFieldTrait`
* Implemented `AbstractCollectionTest.php`
* Updated `AbstractCollection.php`
* Refactored Collections to store `ITEM_TYPE` of included items.

## 1.2.0

* Implemented coverage for `captureOrderTransaction` method from `ginger-php`.
* Implemented `OrderStub` to simplify valid order creation methods.
* Implemented `CaptureOrderTransactionTest`.
* Implemented `OrderNotFoundException` and used in `getOrder` method.
* Implemented `CaptureFailedExcpetion`.
* Implemented `getStatus` and `getId` methods to Order entity.
* Refactored `sendOrder` to return `Order` entity instead of array.
* Refactored code according to `PHPStan` analyse.
* Refactored `AbstractCollection` to not include `class-string` into construct.
* Added `PHPStan` to `composer.json` to a dev environment.
* Updated Customer entity to support cross usage.
* Updated Event entity to support cross usage.
* Updated Transaction entity to support cross usage.
* Updated Order entity to support cross usage.

## 1.3.0

* Implemented coverage for `getIdealIssuers` method from `ginger-php`
* Implemented coverage for `RefundOrder` method.
* Implemented `filterAdditionalProperties` method.
* Implemented `Amount` Property.
* Implemented `RefundFailedException`.
* Implemented `InvalidOrderStatusException`.
* Implemented `Issuer` Entity.
* Implemented `IdealIssuers` Collection.
* Implemented `IdealIssuersTest`.
* Implemented `IssuerTest`.
* Implemented `GetIdealIssuersTest`.
* Implemented `MultiFieldEntityTraitTest`.
* Implemented `RefundOrderTest`.
* Implemented `ValueInCentsInterface`.
* Updated `LineTest`.
* Updated `EventTest`.
* Updated `CreateOrderTest`.
* Updated `OrderLinesTest`.
* Updated `TransactionTest`.
* Simplified `Event` entity.
* Simplified `Transaction` entity.

## 1.4.0

* Implemented supporting `update` method for such collections :
    * Order Lines.
    * Abstract Collection.
    * Additional Addresses.
    * Transactions.
    * Phone Numbers.
* Implemented supporting `update` method for such entities :
    * Line.
    * Address.
    * Customer.
    * Extra.
    * Payment Method Details.
    * Transaction.
* Implemented `update` method to `MultiFieldEntityInterface`.
* Implemented properties:
    * `RawCost`.
    * `Percentage`.
    * `VatPercentage`
* Implemented tests:
    * `RawCostTest`.
    * `AmountTest`.
    * `VatPercentageTest`.
    * `UpdateOrderTest`.
* Updated and Simplified:
    * `AdditionallAddressesTest`.
    * `CustomerTtest`.
    * `TransactionTest`.
* Updated  `get` calls for such entities:
    * Order.
    * Customer.
    * Transaction.
* Redesigned `Amount` property to expect two possible variants in constructor `RawCost` property or value in cents.
* Redesigned `fromArray` method to be static.
* Updated tests to use `fromArray` as a static method.
* Updated `fromArray` method.
* Implemented `merchant_order_id` property for the `Order` entity.
* Eliminated `ValueIncentsInterface`.

## 1.4.1

* Resolved issue when `update()` method doesn't use `validate()` method of unregistered single field properties.

## 1.4.2

* Eliminated `InvalidOrderDataException`.
* Eliminated `AbstractCollectionContainerInterface`.
* Eliminated `getField()` method.
* Eliminated enumeration for payment method name in `Transaction` entity.
* Eliminated enumeration for customer type in `Customer` entity.
* Covered by tests:
    * `addIssuer()`;
    * `removeIssuer()`;
    * `addAddress()`;
    * `removeAddress`;
    * `addLine()`;
    * `removeLine()`;
    * `removePhoneNumber()`;
    * `getAddressType()`;
    * `updateTransaction()`;
    * `addTransaction()`;
    * `removeTransaction()`;
    * `getUserAgent()`;
    * `getPlatformName()`;
    * `getPlatformVersion()`;
    * `getPluginName()`;
    * `getPluginVersion()`;
    * `getMerchantOrderId()`;
    * `getType()`;
    * `isCaptured()`;
    * `getPaymentMethodDetails()`;
    * `getVatPercentage()`;
    * `getCurrency()`;
    * `getMerchantOrderLineId()`;
    * `getName()`;
    * `getQuantity()`;
    * `getId()`;
* Update tests:
  * `AbstractCollectionTest`.
  * `UpdateOrderTest`.
  * `PhoneNumberTest`.
* Updated `OrderLines` collection.
* Updated few methods `AbstractCollection`.
* Updated `fromArray()`.
* Updated `update()` method from `MultiFieldEntityTrait`.
* Implemented `isCollection(), isSameType()` method for `HelperTrait`.
* Implemented check to avoid different type of items in `AbstractCollection`.
* Implemented `reindex()`, `resetPointer()` method for `AbstractCollection`.
* Implemented `OrderTest`.
* Implemented support for webhook and return url in `Order` Entity.
* Implemented `getPaymentUrl()` for `Order` and `Transaction` Entity.

## 1.4.3

* Abstract Collection now actually abstract.
* Resolved issue, when payment method details does force connection to any transaction.
* Resolved issue, when enumeration of Status field being bottleneck for whole Order.

## 1.4.4

* Resolved issue, when `refundOrder()` sent request that server could not understand.
* Updated diapason of VatPercentage according to documentation.
* Implemented partial refunds.
* Implemented check if refund is already done and `RefundAlreadyDoneException` for it.
* Implemented `getFlags()` for `Order` Entity and covered by test.
* Added `getReason()` and `getCustomerMessage()` methods for `Transaction`.
* Updated test `TransactionTest`.
* Resolved issue when positional argument used after named argument.
