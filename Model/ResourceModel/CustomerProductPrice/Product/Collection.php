<?php

namespace Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\Product;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\Product as ResourceModel;
use Extensions\CustomerPricing\Model\CustomerProductPrice\Product as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\Product
 */
class Collection extends AbstractCollection
{
    /**
    * Set resource model
    *
    * @return void
    * @codeCoverageIgnore
    */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
