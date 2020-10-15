<?php

namespace Extensions\CustomerPricing\Model\CustomerProductPrice\Source;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Customer
 *
 * @package Extensions\CustomerPricing\Model\CustomerProductPrice
 */
class Customer implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Customer constructor.
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (empty($this->options)) {
            $this->options[] = [
                'label' => __('Please select customer'),
                'value' => '',
            ];
            $collection = $this->collectionFactory->create();
            foreach ($collection as $customer) {
                $this->options[] = [
                    'label' => $customer->getEmail(),
                    'value' => $customer->getId(),
                ];
            }
        }

        return $this->options;
    }
}
