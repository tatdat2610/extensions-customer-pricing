<?php

namespace Extensions\CustomerPricing\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class CustomerProductPrice
 *
 * @package Extensions\CustomerPricing\Model\ResourceModel
 */
class CustomerProductPrice extends AbstractDb
{
    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * CustomerProductPrice constructor.
     *
     * @param Context $context
     * @param DateTime $dateTime
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        $connectionName = null
    ) {
        $this->dateTime = $dateTime;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize main table and table id field
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init('customer_catalog_price', 'entity_id');
    }

    /**
     * @param $productId
     * @param $customerId
     *
     * @return array
     */
    public function getProductPriceByCustomerId($productId, $customerId)
    {
        $currentTimeStamp = $this->dateTime->timestamp();
        $now = date('Y-m-d H:i:s', $currentTimeStamp);
        $connection = $this->getConnection();
        $select = $connection->select()
                    ->from($connection->getTableName('customer_catalog_price_flat'), ['price'])
                    ->where('is_active = ?', 1)
                    ->where('product_id = ?', $productId)
                    ->where('customer_id = ?', $customerId)
                    ->where('from_date <= ? OR from_date IS NULL', $now)
                    ->where('to_date >= ? OR to_date IS NULL', $now)
                    ->order('sort_order');

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * @param array $productIds
     * @param int $customerId
     *
     * @return array
     */
    public function getListProductsPriceByCustomerId($productIds, $customerId)
    {
        $currentTimeStamp = $this->dateTime->timestamp();
        $now = date('Y-m-d H:i:s', $currentTimeStamp);
        $connection = $this->getConnection();
        $select = $connection->select()
                    ->from($connection->getTableName('customer_catalog_price_flat'), ['product_id', 'price'])
                    ->where('is_active = ?', 1)
                    ->where('product_id in (?)', $productIds)
                    ->where('customer_id = ?', $customerId)
                    ->where('from_date <= ? OR from_date IS NULL', $now)
                    ->where('to_date >= ? OR to_date IS NULL', $now)
                    ->order('sort_order');

        return $this->getConnection()->fetchAll($select);
    }
}
