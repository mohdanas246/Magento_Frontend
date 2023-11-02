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


    public function __construct(Context     $context, FormFactory $formFactory,
                                PageFactory $resultPageFactory, ResourceModel $resourceModel)
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
//            $model->$this->setData($data)->save();
            $this->resourceModel->load($model, $data);

//            $block = $resultPage->getLayout()->getBlock('customer_edit');
            $this->messageManager->addSuccessMessage(__("Data Edit Successfully.."));

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something Went Wrong"));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('employee/form/index');
        return $redirect;
    }
}

//namespace Codilar\Employee\Controller\Form;
//
//use Magento\Framework\App\Action\Action;
//use Magento\Framework\App\Action\Context;
//use Magento\Framework\Controller\ResultFactory;
//use Magento\Framework\UrlInterface;
//use Magento\Framework\View\Result\PageFactory;
//use Codilar\Employee\Model\FormFactory;
//
//class Edit extends Action
//{
//    protected PageFactory $resultPageFactory;
//
//    private $formFactory;
//
//    private $url;
//
//    public function __construct(UrlInterface $url, FormFactory $formFactory, Context $context, PageFactory $resultPageFactory)
//    {
//        parent::__construct($context);
//        $this->resultPageFactory = $resultPageFactory;
//        $this->formFactory = $formFactory;
//        $this->url = $url;
//    }
//
//    public function execute()
//    {
//        if ($this->isCorrectData()) {
//            return $this->resultPageFactory->create();
//        } else {
//            $this->messageManager->addErrorMessage(__("Record Not Found"));
//            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//            $resultRedirect->setUrl($this->url->getUrl('employee/form/index'));
//            return $resultRedirect;
//        }
//    }
//
//    public function isCorrectData()
//    {
//        if ($id = $this->getRequest()->getParam("id")) {
//            $model = $this->formFactory->create();
//            $model->load($id);
//            if ($model->getId()) {
//                return true;
//            } else {
//                return false;
//            }
//        } else {
//            return true;
//        }
//    }
//}
