<?php

namespace GingerPay\Payment\Model\Builders;

use Magento\Framework\App\Area;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Framework\DataObject;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Store\Model\App\Emulation;
use GingerPay\Payment\Api\Config\RepositoryInterface as ConfigRepository;
use Magento\Checkout\Model\Session;

class HelperDataBuilder extends AbstractHelper
{
    public $configRepository;
    /**
     * @var Emulation
     */
    protected $emulation;
    /**
     * @var Session
     */
    protected $checkoutSession;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Quote\Model\QuoteFactory $quote,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        ConfigRepository $configRepository,
        Emulation $emulation,
        Session $checkoutSession
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->orderSender = $orderSender;
        $this->configRepository = $configRepository;
        $this->emulation = $emulation;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context);
    }
    /*
    * create order programmatically
    */
    public function createOrder($orderInfo)
    {
        $store = $this->storeManager->getStore();
        $storeId = $store->getStoreId();

        $quote = $this->checkoutSession->getQuote();

        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($orderInfo->getCustomerEmail());// load customer by email address

        if (!$customer->getId()) {
            //For guest customer create new customer
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($orderInfo->getCustomerFirstname())
                ->setLastname($orderInfo->getCustomerLastname())
                ->setEmail($orderInfo->getCustomerEmail())
                ->setPassword($orderInfo->getCustomerEmail());
            $customer->save();
        }

        $quote = $this->quote->create(); //Create object of quote
        $quote->setStore($store); //set store for our quote
        /* for registered customer */
        $customer = $this->customerRepository->getById($customer->getId());
        $quote->setCurrency();
        $quote->assignCustomer($customer); //Assign quote to customer
        $items = $orderInfo->getItems();

        try {
            //add items in quote
            foreach ($items as $item) {
                $product = $this->productRepository->getById($item->getProductId());
                $quote->addProduct($product, intval($item->getQtyOrdered()));
            }
        } catch (\Exception $e) {
            $result = ['error' => true, 'msg' => __('Some of the products are not in the store. '). __('Subscription canceled').' Order №'.$orderInfo->getIncrementId()];
            $this->configRepository->addTolog('error', $result['msg']);

            return $result;
        }


        $billingAddress = $this->getAddressArray($orderInfo->getBillingAddress());

        //Set Billing and shipping Address to quote
        $quote->getBillingAddress()->addData($billingAddress);
        $quote->getShippingAddress()->addData($billingAddress);

        $quote->setRemoteIp($orderInfo->getRemoteIp());
        // set shipping method

        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod($orderInfo->getShippingMethod()); //shipping method, please verify flat rate shipping must be enable
        $quote->setPaymentMethod($orderInfo->getPayment()->getMethod()); //payment method, please verify checkmo must be enable from admin
        $quote->setInventoryProcessed(false); //decrease item stock equal to qty
        $quote->save(); //quote save
        // Set Sales Order Payment, We have taken check/money order

        $quote->getPayment()->importData(['method' => $orderInfo->getPayment()->getMethod()]);

        // Collect Quote Totals & Save
        $quote->collectTotals()->save();

        // Create Order From Quote Object
        $order = $this->quoteManagement->submit($quote);

        /* for send order email to customer email id */

        //$this->orderSender->send($order);

        /* get order real id from order */
        $orderId = $order->getIncrementId();

        if ($orderId)
        {
            $this->configRepository->addTolog('success', __('Subscription order created sucessfully').' №'.$orderId);
            $result = ['success' => $orderId, 'order' => $order];

            return $result;
        }
        $this->configRepository->addTolog('error', __('Error occurs for subscription Order placing'));
        $result = ['error' => true, 'msg' => __('Error occurs for Order placed')];

        return $result;
    }

    public function getAddressArray($orderAddress)
    {
        $addressArray = array_filter([
            'firstname'    => $orderAddress->getFirstname(),
            'lastname'     => $orderAddress->getLastname(),
            'prefix' => $orderAddress->getPrefix(),
            'suffix' => $orderAddress->getSuffix(),
            'street' => $orderAddress->getStreet(),
            'city' => $orderAddress->getCity(),
            'country_id' => $orderAddress->getCountryId(),
            'region' => $orderAddress->getRegion(),
            'region_id' => $orderAddress->getRegionId(),
            'postcode' => $orderAddress->getPostcode(),
            'telephone' => $orderAddress->getTelephone(),
            'fax' => $orderAddress->getFax(),
            'save_in_address_book' => 1
        ]);
        return $addressArray;
    }
}