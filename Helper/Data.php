<?php

namespace Codilar\Employee\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
//use Magento\Framework\App\Helper\Context;
//use Magento\Framework\Module\Manager;

class Data extends AbstractHelper
{
//    private Manager $moduleManager;
//
//    public function __construct(Context $context, Manager $moduleManager)
//    {
//        $this->moduleManager = $moduleManager;
//        parent::__construct($context);
//    }
//    public function isModuleEnable()
//    {
//
//        return $this->moduleManager->isEnabled('Codilar_FrontUi');
//    }

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
