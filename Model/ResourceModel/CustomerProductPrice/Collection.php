<?php

namespace Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice;

use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice as ResourceModel;
use Extensions\CustomerPricing\Model\CustomerProductPrice as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice
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
