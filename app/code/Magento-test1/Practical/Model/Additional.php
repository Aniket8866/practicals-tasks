<?php

namespace Magento360\Practical\Model;

use Magento\Framework\Model\AbstractModel;
use Magento360\Practical\Model\ResourceModel\Additional as ResourceModel;

class Additional extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
