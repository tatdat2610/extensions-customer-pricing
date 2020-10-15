<?php

namespace Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Product
 *
 * @package Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice
 */
class Product extends AbstractDb
{
    /**
     * Initialize main table and table id field
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init('customer_catalog_price_product', 'entity_id');
    }

    /**
     * @param int $id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteByCustomerPriceId(int $id) : void
    {
        $table = $this->getMainTable();
        $this->getConnection()->delete($table, ['customer_catalog_price_id = ?' => $id]);
    }

    /**
     * @param array $insertData
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateData(array $insertData) : void
    {
        $table = $this->getMainTable();
        $this->getConnection()->insertOnDuplicate($table, $insertData, ['price']);
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductByCustomerPriceId(int $id) : array
    {
        $select = $this->getConnection()
            ->select()->from($this->getMainTable())->where('customer_catalog_price_id = ?', $id);

        return $this->getConnection()->fetchAll($select);
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getIndexData(int $id = 0) : array
    {
        $select = $this->getConnection()
            ->select()->from(
                ['pr' => $this->getMainTable()],
                ['customer_catalog_price_id', 'product_id', 'price']
            )->joinLeft(
                ['cu_pr' => $this->getTable('customer_catalog_price')],
                'pr.customer_catalog_price_id = cu_pr.entity_id',
                ['customer_id', 'from_date', 'to_date', 'is_active', 'sort_order']
            )->where('cu_pr.is_active = ?', 1);
        if ($id) {
            $select->where('pr.customer_catalog_price_id = ?', $id);
        }

        return $this->getConnection()->fetchAll($select);
    }
}
