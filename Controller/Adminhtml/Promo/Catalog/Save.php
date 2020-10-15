<?php

namespace Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog;

use Extensions\CustomerPricing\Api\CustomerProductPriceRepositoryInterface;
use Extensions\CustomerPricing\Model\CustomerProductPriceFactory;
use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\ProductFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class Save
 *
 * @package Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog
 */
class Save extends \Extensions\CustomerPricing\Controller\Adminhtml\Promo\Catalog implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * @var CustomerProductPriceRepositoryInterface
     */
    protected $customerProductPriceRepository;

    /**
     * @var CustomerProductPriceFactory
     */
    protected $customerProductPriceFactory;

    /**
     * @var ProductFactory
     */
    protected $productPriceFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DateTime $dateFilter
     * @param DataPersistorInterface $dataPersistor
     * @param TimezoneInterface $localeDate
     * @param CustomerProductPriceRepositoryInterface $customerProductPriceRepository
     * @param CustomerProductPriceFactory $customerProductPriceFactory
     * @param ProductFactory $productPriceFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DateTime $dateFilter,
        DataPersistorInterface $dataPersistor,
        TimezoneInterface $localeDate,
        CustomerProductPriceRepositoryInterface $customerProductPriceRepository,
        CustomerProductPriceFactory $customerProductPriceFactory,
        ProductFactory $productPriceFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->localeDate = $localeDate;
        $this->customerProductPriceRepository = $customerProductPriceRepository;
        $this->customerProductPriceFactory = $customerProductPriceFactory;
        $this->productPriceFactory = $productPriceFactory;
        parent::__construct($context, $coreRegistry, $dateFilter);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        if ($data = $this->getRequest()->getPostValue()) {
            $repository = $this->customerProductPriceRepository;
            $model = $this->customerProductPriceFactory->create();

            try {
                if (empty($data['products'])) {
                    throw new LocalizedException(__('You have not select any products.'));
                }
                if (!$this->getRequest()->getParam('from_date')) {
                    $data['from_date'] = $this->localeDate->formatDate();
                }
                $filterValues = ['from_date' => $this->_dateFilter];
                if ($this->getRequest()->getParam('to_date')) {
                    $filterValues['to_date'] = $this->_dateFilter;
                }
                $inputFilter = new \Zend_Filter_Input(
                    $filterValues,
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                $id = $this->getRequest()->getParam('entity_id');
                if ($id) {
                    $model = $repository->get($id);
                }

                $model->setData($data);
                $this->dataPersistor->set('customer_product_price', $data);
                if (!$id) {
                    $model->setId(null);
                }
                $customerProductPrice = $repository->save($model);
                $products = $data['products'];
                $insertData = [];
                $customerProductPriceId = $customerProductPrice->getEntityId();
                if ($customerProductPriceId) {
                    foreach ($products as $product) {
                        $insertData[] = [
                            'customer_catalog_price_id' => $customerProductPriceId,
                            'product_id' => $product['product_id'],
                            'price' => $product['price']
                        ];
                    }
                }
                if (!empty($insertData)) {
                    $productPriceResource = $this->productPriceFactory->create();
                    $productPriceResource->deleteByCustomerPriceId($customerProductPriceId);
                    $productPriceResource->updateData($insertData);
                }
                $this->messageManager->addSuccessMessage(__('You saved the record.'));
                $this->dataPersistor->clear('customer_product_price');

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('customer_pricing/*/edit', ['entity_id' => $model->getId()]);
                    return;
                }
                $this->_redirect('customer_pricing/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the record data. Please review the error log.')
                );
                $this->dataPersistor->set('customer_product_price', $data);
                $this->_redirect('customer_pricing/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
                return;
            }
        }
        $this->_redirect('customer_pricing/*/');
    }
}
