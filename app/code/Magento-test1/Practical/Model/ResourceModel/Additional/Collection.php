<?php
namespace Magento360\Practical\Model\ResourceModel\Additional;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento360\Practical\Model\Additional as Model;
use Magento360\Practical\Model\ResourceModel\Additional as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
