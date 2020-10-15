<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\DateTime;
use Extensions\CustomerPricing\Api\CustomerProductPriceRepositoryInterface;

/**
 * Class Delete
 *
 * @package Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog
 */
class Delete extends \Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog implements HttpPostActionInterface
{
    /**
     * @var CustomerProductPriceRepositoryInterface
     */
    protected $customerProductPriceRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DateTime $dateFilter
     * @param CustomerProductPriceRepositoryInterface $customerProductPriceRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DateTime $dateFilter,
        CustomerProductPriceRepositoryInterface $customerProductPriceRepository
    ) {
        $this->customerProductPriceRepository = $customerProductPriceRepository;
        parent::__construct($context, $coreRegistry, $dateFilter);
    }

    /**
     * @return void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                $this->customerProductPriceRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
                $this->_redirect('customer_pricing/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete this record right now. Please review the log and try again.')
                );
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
                $this->_redirect('customer_pricing/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to delete.'));
        $this->_redirect('customer_pricing/*/');
    }
}
