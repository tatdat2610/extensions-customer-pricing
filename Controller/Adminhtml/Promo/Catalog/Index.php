<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Class Index
 *
 * @package Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog
 */
class Index extends \Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog implements HttpGetActionInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Customer Product Price'), __('Customer Product Price'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Customer Product Price'));
        $this->_view->renderLayout();
    }
}
