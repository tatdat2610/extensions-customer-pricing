<?php

namespace Extensions\CustomerPricing\Model\CustomerProductPrice;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\CollectionFactory;
use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\Product;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Product $product
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Product $product,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->product = $product;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $this->loadedData[$item->getId()]['products'] = $this->getProductsByCustomerPriceId($item->getId());
        }

        $data = $this->dataPersistor->get('customer_product_price');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getId()] = $item->getData();
            $this->dataPersistor->clear('customer_product_price');
        }

        return $this->loadedData;
    }

    /**
     * @param $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getProductsByCustomerPriceId($id)
    {
        return $this->product->getProductByCustomerPriceId($id);
    }
}
