<?php

namespace Developer\ProductWarranty\Api;

use Developer\ProductWarranty\Api\Warranty\WarrantyInterface;
use Developer\ProductWarranty\Model\Warranty;

interface WarrantyRepositoryInterface
{
    /**
     * @param WarrantyInterface $warranty
     * @return WarrantyInterface
     */
    public function save(WarrantyInterface $warranty): WarrantyInterface;

    /**
     * @param int $productId
     * @return WarrantyInterface
     */
    public function getByProductId(int $productId): WarrantyInterface;

    /**
     * @param int $productId
     * @return bool
     */
    public function deleteByProductId(int $productId): bool;


}
