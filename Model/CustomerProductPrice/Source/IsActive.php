<?php

namespace Extensions\CustomerPricing\Model\CustomerProductPrice\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 *
 * @package Extensions\CustomerPricing\Model\CustomerProductPrice
 */
class IsActive implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Enable'),
                'value' => 1,
            ],
            [
                'label' => __('Disable'),
                'value' => 0,
            ],
        ];
    }
}
