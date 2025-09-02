<?php

namespace Developer\ProductWarranty\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Warranty extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('product_warranty', 'entity_id');
    }
}
