<?php

namespace Extensions\CustomerPricing\Api\Data;

/**
 * Interface ProductInterface
 *
 * @package Extensions\CustomerPricing\Api\Data
 */
interface ProductInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ENTITY_ID = 'entity_id';
    const CUSTOMER_CATALOG_PRICE_ID = 'customer_catalog_price_id';
    const PRODUCT_ID = 'product_id';
    const PRICE = 'price';
    /**#@-*/

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setEntityId(int $id);

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $customerCatalogPriceId
     *
     * @return $this
     */
    public function setCustomerCatalogPriceId(int $customerCatalogPriceId);

    /**
     * @return int
     */
    public function getCustomerCatalogPriceId();

    /**
     * @param int $productId
     *
     * @return $this
     */
    public function setProductId(int $productId);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice(float $price);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Extensions\CustomerPricing\Api\Data\ProductExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Extensions\CustomerPricing\Api\Data\ProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Extensions\CustomerPricing\Api\Data\ProductExtensionInterface $extensionAttributes
    );
}
