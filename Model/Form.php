<?php

namespace Codilar\Employee\Model;
use Magento\Framework\Model\AbstractModel;
use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
class Form extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const CACHE_TAG = 'Codilar_Employee';

    protected $_cacheTag = self::CACHE_TAG;
}
