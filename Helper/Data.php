<?php

namespace Codilar\Employee\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
class Data extends AbstractHelper
{
    const XML_PATH_EMPLOYEE = 'Codilar_Employee/';
    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EMPLOYEE .'general/'. $code, $storeId);
    }
    public function getStorefrontConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_EMPLOYEE .'storefront/'. $code, $storeId);
    }
}
