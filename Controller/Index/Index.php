<?php

namespace Codilar\Employee\Controller\Index;
use Magento\Customer\Api\Data\GroupInterfaceFactory;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    protected GroupInterfaceFactory $groupFactory;
    protected GroupRepositoryInterface $groupRepository;

    public function __construct(
        Context                  $context,
        GroupInterfaceFactory    $groupFactory,
        GroupRepositoryInterface $groupRepository
    )
    {
        parent::__construct($context);
        $this->groupFactory = $groupFactory;
        $this->groupRepository = $groupRepository;
    }
    public function execute()
    {
        try {
            $customerGroupCode = 'custom_group'; // Replace with your desired group code
            $taxClassId = 3; // Replace with the desired tax class ID

            $customerGroup = $this->groupFactory->create();
            $customerGroup->setCode($customerGroupCode);
            $customerGroup->setTaxClassId($taxClassId);

            $this->groupRepository->save($customerGroup);

            // Optionally, you can add a success message or perform other actions
            $this->messageManager->addSuccessMessage('Customer group created successfully.');
        } catch (\Exception $e) {
            // Handle any errors or exceptions here
            $this->messageManager->addErrorMessage('Error creating customer group: ' . $e->getMessage());
        }

        return $this->_redirect('employee/index/index'); // Replace with the appropriate URL
    }
}



