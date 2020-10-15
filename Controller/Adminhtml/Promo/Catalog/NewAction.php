<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Class NewAction
 *
 * @package Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog
 */
class NewAction extends \Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog implements HttpGetActionInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
