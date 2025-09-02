<?php

namespace Developer\ProductWarranty\Model;

use Developer\ProductWarranty\Api\Warranty\WarrantyInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Warranty extends AbstractModel implements WarrantyInterface, IdentityInterface
{
    /**
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Warranty::class);
    }

    /**
     * Get Product ID
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int) $this->getData('product_id');
    }

    /**
     * Set Product ID
     *
     * @param int $productId
     * @return WarrantyInterface
     */
    public function setProductId(int $productId): WarrantyInterface
    {
        return $this->setData('product_id', (int)$productId);
    }

    /**
     * Get Warranty
     *
     * @return int
     */
    public function getWarranty(): int
    {
        return (int) $this->getData('warranty');
    }

    /**
     * Set Warranty
     *
     * @param int $warranty
     * @return WarrantyInterface
     */
    public function setWarranty(int $warranty): WarrantyInterface
    {
        return $this->setData('warranty', (int)$warranty);
    }

    /**
     * Get cache identities
     *
     * @return string[]
     */
    public function getIdentities(): array
    {
        return ['warranty_' . $this->getId()];
    }
}
