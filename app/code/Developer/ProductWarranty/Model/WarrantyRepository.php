<?php

namespace Developer\ProductWarranty\Model;

use Developer\ProductWarranty\Api\Warranty\WarrantyInterface;
use Developer\ProductWarranty\Api\WarrantyRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Developer\ProductWarranty\Model\ResourceModel\Warranty as WarrantyResource;
class WarrantyRepository implements WarrantyRepositoryInterface
{
    private WarrantyResource $resourceModel;
    private WarrantyFactory $objectFactory;

    public function __construct(
        WarrantyResource $resourceModel,
        WarrantyFactory $objectFactory,
    ) {
        $this->resourceModel = $resourceModel;
        $this->objectFactory = $objectFactory;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(WarrantyInterface $warranty): WarrantyInterface
    {
        try {
            $warranty->getId();
            $this->resourceModel->save($warranty);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $warranty;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getByProductId(int $productId): WarrantyInterface
    {
        $object = $this->objectFactory->create();
        $object->load($productId, 'product_id');

        if (!$object->getId()) { // check if object exists
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Warranty for product with id "%1" does noty exist.', $productId)
            );
        }

        return $object;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteByProductId(int $productId): bool
    {
        $object = $this->objectFactory->create();
        $object->load($productId, 'product_id');

        if (!$object->getId()) { // check if object exists
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Warranty for product with id "%1" does noty exist.', $productId)
            );
        }
        try {
            $this->resourceModel->delete($object);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }
}
