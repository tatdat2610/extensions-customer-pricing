<?php

namespace Extensions\CustomerPricing\Api\Data;

/**
 * Interface CustomerProductPriceInterface
 *
 * @package Extensions\CustomerPricing\Api\Data
 */
interface CustomerProductPriceInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ENTITY_ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const IS_ACTIVE = 'is_active';
    const SORT_ORDER = 'sort_order';
    const PRODUCTS = 'products';
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
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId(int $customerId);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param string $fromDate
     *
     * @return $this
     */
    public function setFromDate(string $fromDate);

    /**
     * @return string
     */
    public function getFromDate();

    /**
     * @param string $toDate
     *
     * @return $this
     */
    public function setToDate(string $toDate);

    /**
     * @return string
     */
    public function getToDate();

    /**
     * @param int $isActive
     *
     * @return $this
     */
    public function setIsActive(int $isActive);

    /**
     * @return int
     */
    public function getIsActive();

    /**
     * @param int $sortOrder
     *
     * @return $this
     */
    public function setSortOrder(int $sortOrder);

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @param ProductInterface[] $products
     *
     * @return $this
     */
    public function setProducts(array $products);

    /**
     * @return ProductInterface[]
     */
    public function getProducts();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Extensions\CustomerPricing\Api\Data\CustomerProductPriceExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Extensions\CustomerPricing\Api\Data\CustomerProductPriceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Extensions\CustomerPricing\Api\Data\CustomerProductPriceExtensionInterface $extensionAttributes
    );
}
