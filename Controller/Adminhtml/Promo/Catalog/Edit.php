<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog;

use Extensions\CustomerPricing\Api\CustomerProductPriceRepositoryInterface;
use Extensions\CustomerPricing\Model\CustomerProductPriceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\DateTime;

/**
 * Class Edit
 *
 * @package Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog
 */
class Edit extends \Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog implements HttpGetActionInterface
{
    /**
     * @var CustomerProductPriceRepositoryInterface
     */
    protected $customerProductPriceRepository;

    /**
     * @var CustomerProductPriceFactory
     */
    protected $customerProductPriceFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DateTime $dateFilter
     * @param CustomerProductPriceRepositoryInterface $customerProductPriceRepository
     * @param CustomerProductPriceFactory $customerProductPriceFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DateTime $dateFilter,
        CustomerProductPriceRepositoryInterface $customerProductPriceRepository,
        CustomerProductPriceFactory $customerProductPriceFactory
    ) {
        $this->customerProductPriceRepository = $customerProductPriceRepository;
        $this->customerProductPriceFactory = $customerProductPriceFactory;
        parent::__construct($context, $coreRegistry, $dateFilter);
    }

    /**
     * @return void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                $model = $this->customerProductPriceRepository->get($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                $this->_redirect('customer_pricing/*');
                return;
            }
        } else {
            $model = $this->customerProductPriceFactory->create();
        }
        $this->_coreRegistry->register('current_customer_product_price', $model);
        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Customer Product Price'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getEntityId() ? $model->getEntityId() : __('New Customer Product Price')
        );
        $breadcrumb = $id ? __('Edit Customer Product Price') : __('New Customer Product Price');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
