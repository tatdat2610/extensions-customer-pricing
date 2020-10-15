<?php

namespace Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action;

/**
 * Class Full
 *
 * @package Extensions\CustomerPricing\Model\Indexer\CustomerProductPrice\Flat\Action
 */
class Full extends AbstractAction
{
    /**
     * Populate flat tables with data
     *
     * @return Full
     */
    protected function populateFlatTable()
    {
        $data = $this->productFactory->create()->getIndexData();
        $this->connection->insertMultiple(
            $this->addTemporaryTableSuffix($this->getMainTable()),
            $data
        );

        return $this;
    }

    /**
     * Create table and add attributes as fields for specified store.
     *
     * This routine assumes that DDL operations are allowed
     *
     * @return Full
     */
    protected function createTable()
    {
        $temporaryTable = $this->addTemporaryTableSuffix($this->getMainTable());
        $table = $this->getFlatTableStructure($temporaryTable);
        $this->connection->dropTable($temporaryTable);
        $this->connection->createTable($table);

        return $this;
    }

    /**
     * Switch table (temporary becomes active, old active will be dropped)
     *
     * @return Full
     */
    protected function switchTable()
    {
        $activeTableName = $this->getMainTable();
        $temporaryTableName = $this->addTemporaryTableSuffix($this->getMainTable());
        $oldTableName = $this->addOldTableSuffix($this->getMainTable());

        //switch tables
        $tablesToRename = [];
        if ($this->connection->isTableExists($activeTableName)) {
            $tablesToRename[] = ['oldName' => $activeTableName, 'newName' => $oldTableName];
        }

        $tablesToRename[] = ['oldName' => $temporaryTableName, 'newName' => $activeTableName];

        foreach ($tablesToRename as $tableToRename) {
            $this->connection->renameTable($tableToRename['oldName'], $tableToRename['newName']);
        }

        //delete inactive table
        $tableToDelete = $oldTableName;

        if ($this->connection->isTableExists($tableToDelete)) {
            $this->connection->dropTable($tableToDelete);
        }

        return $this;
    }

    /**
     * Transactional rebuild flat data from eav
     *
     * @return Full
     */
    public function reindexAll()
    {
        $this->createTable();
        $this->populateFlatTable();
        $this->switchTable();

        return $this;
    }
}
