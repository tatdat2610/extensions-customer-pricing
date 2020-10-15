<?php

namespace Extensions\CustomerPricing\Observer;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPriceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class CustomerPriceInCart
 *
 * @package Extensions\CustomerPricing\Observer
 */
class CustomerPriceInCart implements ObserverInterface
{
    /**
     * @var CustomerProductPriceFactory
     */
    private $customerProductPriceFactory;

    /**
     * CustomerPriceInCart constructor.
     *
     * @param CustomerProductPriceFactory $customerProductPriceFactory
     */
    public function __construct(
        CustomerProductPriceFactory $customerProductPriceFactory
    ) {
        $this->customerProductPriceFactory = $customerProductPriceFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $customerId = $item->getQuote()->getCustomerId();
        if ($customerId) {
            $productId = $item->getProductId();
            try {
                $price = $this->customerProductPriceFactory->create()->getProductPriceByCustomerId(
                    $productId,
                    $customerId
                );
                if ($price) {
                    $item->setCustomPrice($price);
                    $item->setOriginalCustomPrice($price);
                    $item->getProduct()->setIsSuperMode(true);
                }
            } catch (\Exception $e) {
                //do nothing
            }

        }
    }
}
