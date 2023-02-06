# Ginger Plugin SDK

This library is custom developed for Ginger API, based on schemas from API. <br>
Should be used with payment plugins or for order creation. <br>

# Available functionality :

- Creation Order entity with all related entities.
- Post the new order to Ginger API.

# Overview :

# Entities Overview

- [Transactions](#transactions)
    - Transaction
        - Payment Method
            - [Payment Method Details](#payment-method-details)
- Description
- Amount
- Customer
    - Birthdate
    - Address
        - Country
- Order Lines
    - Line
- Extra
- Client

## Transactions

<i>This entity contains several single transactions, basically no more than 1 transaction.</i>

- To initialize new object :

```php
$transactions = new Transactions(
    new Transaction(...)
);
```

- To add new transaction :

```php
$transactions->addTransaction($transaction);
```

- To remove transaction by index :

```php
$transactions->removeTransaction($index);
```

### Transaction

<i>This entity contains general payment information. You should use this entity to tell the API how to process your
request.</i>

- To initialize new object :

```php
$transaction = new Transaction(
    paymentMethod: "apple-pay"
);
```

- To add Payment Method Details there is two ways :
    - While initializing
  ```php
  $transaction = new Transaction(
    paymentMethod: "ideal",
    paymentMethodDetails: new PaymentMethodDetails(...)
  );  
    ```
    - Through std object exemplar, in way of expanding its properties (for now only with prepared for payment methods).
  ```php
  $transaction->getPaymentMethodDetails()->setPaymentMethodDetailsIdeal();
  ```

- To receive a Payment Method Details :

```php
$transaction->getPaymentMethodDetails();
```

### Payment Method

<i>This field should be used to store payment name.</i>

#### Payment Method Details

<i>This entity contains additional payload for payment method, such as issuer id, hosted fields data <br>
or data for recurring payments.</i>

- For now, only string types of attributes values are supported.