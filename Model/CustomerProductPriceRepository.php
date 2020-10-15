<?php

namespace Extensions\CustomerPricing\Model;

use Extensions\CustomerPricing\Api\CustomerProductPriceRepositoryInterface;
use Extensions\CustomerPricing\Api\Data;
use Extensions\CustomerPricing\Model\ResourceModel\CustomerProductPrice as ResourceModel;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;

/**
 * Class CustomerProductPriceRepository
 *
 * @package Extensions\CustomerPricing\Model
 */
class CustomerProductPriceRepository implements CustomerProductPriceRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    protected $customerProductPriceResource;

    /**
     * @var CustomerProductPriceFactory
     */
    protected $customerProductPriceFactory;

    /**
     * @var array
     */
    private $customerProductPrices = [];

    /**
     * CustomerProductPriceRepository constructor.
     *
     * @param ResourceModel $customerProductPriceResource
     * @param CustomerProductPriceFactory $customerProductPriceFactory
     */
    public function __construct(
        ResourceModel $customerProductPriceResource,
        CustomerProductPriceFactory $customerProductPriceFactory
    ) {
        $this->customerProductPriceResource = $customerProductPriceResource;
        $this->customerProductPriceFactory = $customerProductPriceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Data\CustomerProductPriceInterface $customerProductPrice)
    {
        if ($id = $customerProductPrice->getEntityId()) {
            $customerProductPrice = $this->get($id)->addData($customerProductPrice->getData());
        }

        try {
            $this->customerProductPriceResource->save($customerProductPrice);
            unset($this->customerProductPrices[$customerProductPrice->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The "%1" record was unable to be saved. Please try again.', $customerProductPrice->getEntityId())
            );
        }

        return $customerProductPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function get($customerProductPriceId)
    {
        if (!isset($this->customerProductPrices[$customerProductPriceId])) {
            $customerProductPrice = $this->customerProductPriceFactory->create();
            $customerProductPrice->load($customerProductPriceId);
            if (!$customerProductPrice->getEntityId()) {
                throw new NoSuchEntityException(
                    __(
                        'The record with the "%1" ID wasn\'t found. Verify the ID and try again.',
                        $customerProductPriceId
                    )
                );
            }
            $this->customerProductPrices[$customerProductPriceId] = $customerProductPrice;
        }

        return $this->customerProductPrices[$customerProductPriceId];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Data\CustomerProductPriceInterface $customerProductPrice)
    {
        try {
            $this->customerProductPriceResource->delete($customerProductPrice);
            unset($this->customerProductPrices[$customerProductPrice->getEntityId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('The "%1" record couldn\'t be removed.',
                $customerProductPrice->getEntityId()));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($customerProductPriceId)
    {
        $model = $this->get($customerProductPriceId);
        $this->delete($model);

        return true;
    }
}
