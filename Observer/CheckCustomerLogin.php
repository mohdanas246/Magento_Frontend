<?php

namespace Codilar\Employee\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Customer\Model\Session as CustomerSession;

class CheckCustomerLogin implements ObserverInterface
{
    protected ManagerInterface $messageManager;
    protected CustomerSession $customerSession;

    public function __construct(
        ManagerInterface $messageManager,
        CustomerSession $customerSession
    ) {
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        if (!$this->customerSession->isLoggedIn()) {
            $this->messageManager->addErrorMessage(__('Sorry Customer does not exist.'));
            $result = $observer->getEvent()->getResult();
            $result->setHasError(true);
            $result->setError(__('Customer must be logged in to add products to your cart.'));
        }
    }
}
