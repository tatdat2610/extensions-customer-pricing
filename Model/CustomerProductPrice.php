<?php

namespace Extensions\CustomerPricing\Model;

use Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface;
use Extensions\CustomerPricing\Api\Data\CustomerProductPriceExtensionInterface;
use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice as ResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class CustomerProductPrice
 *
 * @package Extensions\CustomerPricing\Model
 */
class CustomerProductPrice extends AbstractExtensibleModel implements CustomerProductPriceInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomerId(int $customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setFromDate(string $fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    /**
     * {@inheritDoc}
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * {@inheritDoc}
     */
    public function setToDate(string $toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }

    /**
     * {@inheritDoc}
     */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsActive(int $isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritDoc}
     */
    public function setSortOrder(int $sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * {@inheritDoc}
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * {@inheritDoc}
     */
    public function setProducts(array $products)
    {
        return $this->setData(self::PRODUCTS, $products);
    }

    /**
     * {@inheritDoc}
     */
    public function getProducts()
    {
        return $this->getData(self::PRODUCTS);
    }

    /**
     * {@inheritDoc}
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritDoc}
     */
    public function setExtensionAttributes(CustomerProductPriceExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
