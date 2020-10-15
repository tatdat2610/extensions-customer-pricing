<?php

namespace Extensions\CustomerPricing\Controller\Customer;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPriceFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Customer\Model\Session;

/**
 * Class Price
 *
 * @package Extensions\CustomerPricing\Controller\Customer
 */
class Price extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    /**
     * @var CustomerProductPriceFactory
     */
    private $customerProductPriceFactory;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * Price constructor.
     *
     * @param Context $context
     * @param CustomerProductPriceFactory $customerProductPriceFactory
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        CustomerProductPriceFactory $customerProductPriceFactory,
        Session $customerSession
    ) {
        $this->customerProductPriceFactory = $customerProductPriceFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $productIds = $this->getRequest()->getParam('productIds');
        $customerId = $this->customerSession->getCustomer()->getId();
        $data = [];
        $response = new \Magento\Framework\DataObject();
        try {
            $data = $this->customerProductPriceFactory->create()->getListProductsPriceByCustomerId($productIds, $customerId);
        } catch (\Exception $e) {
            //do nothing
        }
        $response->setData($data);

        $this->getResponse()->representJson($response->toJson());
    }
}
