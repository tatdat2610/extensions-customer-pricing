<?php

namespace Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\ProductFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class AbstractAction
 *
 * @package Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action
 */
class AbstractAction
{
    /**
     * Suffix for table to show it is old
     */
    const OLD_TABLE_SUFFIX = '_old';

    /**
     * Suffix for table to show it is temporary
     */
    const TEMPORARY_TABLE_SUFFIX = '_tmp';

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var
     */
    protected $productFactory;

    /**
     * AbstractAction constructor.
     *
     * @param ResourceConnection $resource
     * @param ProductFactory $productFactory
     */
    public function __construct(
        ResourceConnection $resource,
        ProductFactory $productFactory
    ) {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->productFactory = $productFactory;
    }

    /**
     * Return structure for flat table
     *
     * @param string $tableName
     *
     * @return \Magento\Framework\DB\Ddl\Table
     * @throws \Zend_Db_Exception
     */
    protected function getFlatTableStructure($tableName)
    {
        $table = $this->connection->newTable(
            $tableName
        )->setComment(
            'Customer Catalog Price Flat'
        );

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false, 'primary' => true, 'identity' => true],
            'Entity ID'
        );

        $table->addColumn(
            'customer_catalog_price_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Customer Catalog Price ID'
        );

        $table->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Customer ID'
        );

        $table->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Product ID'
        );

        $table->addColumn(
            'price',
            Table::TYPE_DECIMAL,
            10,
            ['unsigned' => false, 'nullable' => false, 'scale' => 4, 'precision' => 12, 'default' => 0],
            'Price'
        );

        $table->addColumn(
            'from_date',
            Table::TYPE_DATETIME,
            null,
            [],
            'From Date'
        );

        $table->addColumn(
            'to_date',
            Table::TYPE_DATETIME,
            null,
            [],
            'To Date'
        );

        $table->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            6,
            ['unsigned' => false, 'nullable' => false, 'scale' => 4, 'precision' => 12, 'default' => 0],
            'Is Active'
        );

        $table->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            10,
            ['unsigned' => false, 'nullable' => false, 'scale' => 4, 'precision' => 12, 'default' => 0],
            'Is Active'
        );

        $table->addIndex(
            $this->connection->getIndexName($tableName, ['customer_id', 'product_id', 'from_date', 'to_date']),
            ['customer_catalog_price_id', 'customer_id', 'product_id', 'from_date', 'to_date'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        );

        return $table;
    }

    /**
     * Add suffix to table name to show it is temporary
     *
     * @param string $tableName
     * @return string
     */
    protected function addTemporaryTableSuffix($tableName)
    {
        return $tableName . self::TEMPORARY_TABLE_SUFFIX;
    }

    /**
     * Add suffix to table name to show it is old
     *
     * @param string $tableName
     * @return string
     */
    protected function addOldTableSuffix($tableName)
    {
        return $tableName . self::OLD_TABLE_SUFFIX;
    }

    /**
     * Return name of table for given $storeId.
     *
     * @param integer $storeId
     * @return string
     */
    public function getMainTable()
    {
        $table = $this->connection->getTableName($this->getTableName('customer_catalog_price_flat'));

        return $table;
    }

    /**
     * Get table name
     *
     * @param string $name
     * @return string
     */
    protected function getTableName($name)
    {
        return $this->resource->getTableName($name);
    }
}
