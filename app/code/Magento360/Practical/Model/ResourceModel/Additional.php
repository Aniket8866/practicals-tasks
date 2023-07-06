<?php

namespace Magento360\Practical\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Additional extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_additional_information', 'id');
    }
}
