<?php

namespace Developer\ProductWarranty\Model\ResourceModel\Warranty;

use Developer\ProductWarranty\Model\ResourceModel\Warranty as WarrantyResource;
use Developer\ProductWarranty\Model\Warranty as WarrantyModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(WarrantyModel::class, WarrantyResource::class);
    }
}
