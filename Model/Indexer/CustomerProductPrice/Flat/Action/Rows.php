<?php

namespace Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action;

/**
 * Class Rows
 *
 * @package Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action
 */
class Rows extends AbstractAction
{
    /**
     * Return index table name
     *
     * @param bool $useTempTable
     * @return string
     */
    protected function getTableName($useTempTable)
    {
        $tableName = $this->getMainTable();
        return $useTempTable ? $this->addTemporaryTableSuffix($tableName) : $tableName;
    }

    /**
     * Refresh entities index
     *
     * @param int[] $entityIds
     * @param bool $useTempTable
     * @return Rows
     */
    public function reindex(array $entityIds = [], $useTempTable = false)
    {
        $tableName = $this->getTableName($useTempTable);
        if (!$this->connection->isTableExists($tableName)) {
            return;
        }
        $this->updateIndexData($tableName, $entityIds);

        return $this;
    }

    /**
     * Insert or update index data
     *
     * @param string $tableName
     * @param array $entityIds
     */
    private function updateIndexData($tableName, $entityIds)
    {
        foreach ($entityIds as $entityId) {
            $data = $this->productFactory->create()->getIndexData($entityId);
            $this->connection->delete($tableName, ['customer_catalog_price_id = ?' => $entityId]);
            $this->connection->insertOnDuplicate(
                $tableName,
                $data,
                ['price', 'is_active', 'sort_order']
            );
        }
    }
}
