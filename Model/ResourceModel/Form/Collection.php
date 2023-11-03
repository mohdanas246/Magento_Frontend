<?php

namespace Codilar\Employee\Model\ResourceModel\Form;

use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
use Codilar\Employee\Model\Form as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
