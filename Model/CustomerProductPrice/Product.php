<?php

namespace Extensions\CustomerPricing\Model\CustomerProductPrice;

use Extensions\CustomerPricing\Api\Data\ProductInterface;
use Extensions\CustomerPricing\Api\Data\ProductExtensionInterface;
use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice\Product as ResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class Product
 *
 * @package Extensions\CustomerPricing\Model\CustomerProductPrice
 */
class Product extends AbstractExtensibleModel implements ProductInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerCatalogPriceId(int $customerCatalogPriceId)
    {
        return $this->setData(self::CUSTOMER_CATALOG_PRICE_ID, $customerCatalogPriceId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerCatalogPriceId()
    {
        return $this->getData(self::CUSTOMER_CATALOG_PRICE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId(int $productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(float $price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(ProductExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
