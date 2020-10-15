<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\DateTime;

abstract class Catalog extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Extensions_CustomerPricing::promo_catalog';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * Date filter instance
     *
     * @var \Magento\Framework\Stdlib\DateTime\Filter\DateTime
     */
    protected $_dateFilter;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DateTime $dateFilter
     */
    public function __construct(Context $context, Registry $coreRegistry, DateTime $dateFilter)
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_dateFilter = $dateFilter;
    }

    /**
     * Init action
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Magento_CatalogRule::promo_catalog'
        )->_addBreadcrumb(
            __('Promotions'),
            __('Promotions')
        );
        return $this;
    }
}
