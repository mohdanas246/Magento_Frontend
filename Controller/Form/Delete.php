<?php
namespace Codilar\Employee\Controller\Form;

use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Codilar\Employee\Model\FormFactory;


class Delete extends Action
{
    protected $messageManager;

    private FormFactory $entityFactory;
    private ResourceModel $resouceModel;


    public function __construct(Context $context,
                                \Magento\Framework\Message\ManagerInterface $messageManager,
                                FormFactory $entityFactory,  ResourceModel $resourceModel

    )
    {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->entityFactory = $entityFactory;
        $this->resouceModel = $resourceModel;
    }

    public function execute()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $model = $this->entityFactory->create();
            $this->resouceModel->load($model,$id);
            $this->resouceModel->delete($model);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('employee/form/index');
        return $redirect;
    }
}
