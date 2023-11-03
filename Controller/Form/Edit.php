<?php
namespace Codilar\Employee\Controller\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Codilar\Employee\Model\FormFactory;
use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
use Magento\Shipping\Model\Rate\ResultFactory;
class Edit extends Action
{
    protected PageFactory $resultPageFactory;
    private FormFactory $formFactory;
    private ResourceModel $resourceModel;
    public function __construct(Context     $context,
                                FormFactory $formFactory,
                                PageFactory $resultPageFactory,
                                ResourceModel $resourceModel)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->formFactory = $formFactory;
        $this->resourceModel = $resourceModel;

    }
    public function execute()
    {
        try {
            $data = $this->getRequest()->getParam('id');

            $model = $this->formFactory->create();
            $this->resourceModel->load($model, $data);
            $this->messageManager->addSuccessMessage(__("Data Edit Successfully.."));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something Went Wrong"));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('employee/form/index');
        return $redirect;
    }
}
