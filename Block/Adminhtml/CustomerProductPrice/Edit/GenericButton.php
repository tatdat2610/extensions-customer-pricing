<?php

namespace Extensions\CustomerPricing\Block\Adminhtml\CustomerProductPrice\Edit;

use Extensions\CustomerPricing\Api\CustomerProductPriceRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var CustomerProductPriceRepositoryInterface
     */
    protected $customerProductPriceRepository;

    /**
     * @param Context $context
     * @param CustomerProductPriceRepositoryInterface $customerProductPriceRepository
     */
    public function __construct(
        Context $context,
        CustomerProductPriceRepositoryInterface $customerProductPriceRepository
    ) {
        $this->context = $context;
        $this->customerProductPriceRepository = $customerProductPriceRepository;
    }

    /**
     * @return int|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getId()
    {
        try {
            return $this->customerProductPriceRepository->get(
                $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
