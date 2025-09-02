<?php

namespace Developer\ProductWarranty\Api\Warranty;

interface WarrantyInterface
{
    const string ENTITY_ID  = 'entity_id';
    const string PRODUCT_ID = 'product_id';
    const string WARRANTY   = 'warranty';

    /**
     * Get entity id
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set entity id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId);

    /**
     * Get product id
     *
     * @return int
     */
    public function getProductId(): int;

    /**
     * Set product id
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId(int $productId);

    /**
     * Get warranty duration/value
     *
     * @return int
     */
    public function getWarranty(): int;

    /**
     * Set warranty duration/value
     *
     * @param int $warranty
     * @return $this
     */
    public function setWarranty(int $warranty);
}
