<?php

namespace Extensions\CustomerPricing\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface CustomerProductPriceRepositoryInterface
 *
 * @package Extensions\CustomerPricing\Api
 */
interface CustomerProductPriceRepositoryInterface
{
    /**
     * @param \Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface $customerProductPrice
     * @return \Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface
     * @throws CouldNotSaveException
     */
    public function save(\Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface $customerProductPrice);

    /**
     * @param int $customerProductPriceId
     * @return \Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface
     * @throws NoSuchEntityException
     */
    public function get($customerProductPriceId);

    /**
     * @param \Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface $customerProductPrice
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Extensions\CustomerPricing\Api\Data\CustomerProductPriceInterface $customerProductPrice);

    /**
     * @param int $customerProductPriceId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($customerProductPriceId);
}
