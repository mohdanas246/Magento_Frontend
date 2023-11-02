<?php

//namespace Codilar\Employee\Controller\Form;
//
//use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
//use Codilar\Employee\Model\ResourceModel\Form;
//use Magento\Framework\App\Action\Action;
//use Magento\Framework\App\Action\Context;
//use Codilar\Employee\Model\FormFactory;
//use Magento\Framework\App\ResponseInterface;
//use Magento\Framework\Controller\Result\Redirect;
//use Magento\Framework\Controller\ResultInterface;
//
//
//class Save extends Action
//{
//    /**
//     * @var Form
//     */
//    private Form $form;
//    /**
//     * @var ResourceModel
//     */
//    private ResourceModel $resouceModel;
//
//    /**
//     * @var FormFactory
//     */
//    private FormFactory $entityFactory;
//
//
//    /**
//     * @param Context $context
//     * @param Form $form
//     * @param FormFactory $entityFactory
//     * @param ResourceModel $resourceModel
//     */
//    public function __construct(
//        Context       $context,
//        Form          $form,
//        FormFactory   $entityFactory,
//        ResourceModel $resourceModel)
//    {
//        parent::__construct($context);
//        $this->form = $form;
//        $this->entityFactory = $entityFactory;
//        $this->resouceModel = $resourceModel;
//    }
//
//    /**
//     * @return ResultInterface|ResponseInterface|Redirect
//     */
//    public function execute(): ResultInterface|ResponseInterface|Redirect
//    {
//
////        try {
////            $data = $this->getRequest()->getParams();
////
////            $formModel = $this->entityFactory->create();
////            $formModel->set($data);
////
////            $post = $this->getRequest()->getPost();
////            $this->form->setData('first_name', $post['firstName']);
////            $this->form->setData('last_name', $post['lastName']);
////            $this->form->setData('address', $post['address']);
////
////            print_r($post['firstName']);
////            echo '<br>';
////            print_r($post['lastName']);
////            echo '<br>';
////            print_r($post['address']);
////            if(!$data['id']) {
////                $this->messageManager->addSuccessMessage("Form saved successfully!");
////            }
////        } catch (\Exception $exception) {
////            $this->messageManager->addErrorMessage(__("Error saving form"));
////        }
//        $data = $this->getRequest()->getParams();
//        $modelData = $this->entityFactory->create();
//
//        if ($data['id']) {
//            try {
//                $r = $this->resouceModel->load($modelData, $data['id']);
//                $modelData->setData('first_name', $data['firstName']);
//                $modelData->setData('last_name', $data['lastName']);
//                $modelData->setData('address', $data['address']);
//                $r->save($modelData);
//                $this->messageManager->addSuccessMessage("Form edited successfully!");
//            } catch (\Exception $exception) {
//                $this->messageManager->addErrorMessage(__("Error saving form"));
//            }
//        } else {
//            try {
////              $data = $this->getRequest()->getParams();
////                $formModel = $this->entityFactory->create();
////              $formModel->set($data);
//                $post = $this->getRequest()->getPost();
//                $this->form->setData('first_name', $post['firstName']);
//                print_r($post['firstName']);
//                die();
//                $this->form->setData('last_name', $post['lastName']);
//                $this->form->setData('address', $post['address']);
//                $this->resouceModel->save($this->form);
////                print_r($post['firstName']);
////                echo '<br>';
////                print_r($post['lastName']);
////                echo '<br>';
////                print_r($post['address']);
//                $this->messageManager->addSuccessMessage("Form saved successfully!");
//            } catch (\Exception $exception) {
//                $this->messageManager->addErrorMessage(__("Error saving form"));
//            }
//        }
//        $redirect = $this->resultRedirectFactory->create();
//        $redirect->setPath('employee/form/index');
//        return $redirect;
//    }
//
//}
//namespace Codilar\Employee\Controller\Form;
//
//use Magento\Framework\App\Action\Context;
//use Magento\Framework\View\Result\PageFactory;
//use Codilar\Employee\Model\FormFactory;
//use Magento\Framework\Controller\ResultFactory;
//use Magento\Framework\App\Action\Action;
//use Magento\Framework\Mail\Template\TransportBuilder;
//use Magento\Framework\Translate\Inline\StateInterface;
//
//
//
//class Save extends Action
//{
//    protected PageFactory $resultPageFactory;
//    protected FormFactory $formFactory;
//    private TransportBuilder $transportBuilder;
//    private StateInterface $inlineTranslation;
//
//
//
//    public function __construct(
//        Context     $context,
//        PageFactory $resultPageFactory,
//        FormFactory $formFactory,
//        TransportBuilder $transportBuilder,
//        StateInterface $inlineTranslation,
//
//    )
//    {
//        $this->resultPageFactory = $resultPageFactory;
//        $this->formFactory = $formFactory;
//        $this->transportBuilder = $transportBuilder;
//        $this->inlineTranslation = $inlineTranslation;
//
//        parent::__construct($context);
//    }
//    public function execute()
//    {
//        try {
//            $data = (array)$this->getRequest()->getPost();
//            if ($data) {
//                $model = $this->formFactory->create();
//                $model->setData($data)->save();
//
//                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
//            }
//        } catch (\Exception $e) {
//            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
//        }
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//        $resultRedirect->setPath('employee/form/email');
//        return $resultRedirect;
//
//    }
//}

namespace Codilar\Employee\Controller\Form;

use Codilar\Employee\Model\FormFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;

class Save extends Action
{
    protected TransportBuilder $transportBuilder;
    protected StateInterface $inlineTranslation;
    protected Http $request;
    protected FormFactory $formFactory;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        Http $request,
        FormFactory $formFactory
    ) {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->request = $request;
        $this->formFactory = $formFactory;
    }

    /**
     * @throws MailException
     * @throws LocalizedException
     */
    public function execute()
    {

        $post = $this->getRequest()->getPostValue();
        $firstName = $post['first_name'];
        $lastName = $post['last_name'];
        $address = $post['address'];

        // Save the data to the custom table
        $customFormData = $this->formFactory->create();
        $customFormData->addData([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => $address,
        ]);
        $customFormData->save();
//    public function execute()
//    {
//        try {
//            $data = (array)$this->getRequest()->getPost();
//            if ($data) {
//                $model = $this->formFactory->create();
//                $model->setData($data)->save();
//
//                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
//            }
//        } catch (\Exception $e) {
//            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
//        }
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//        $resultRedirect->setPath('employee/form/index');
//        return $resultRedirect;
//
////    }
//        $emailTemplateVariables = [
//            'first_name' => $firstName,
//            'last_name' => $lastName,
//            'address' => $address,
//        ];
//
//        $this->inlineTranslation->suspend();
//        $transport = $this->transportBuilder
//            ->setTemplateIdentifier('custom_email_template')
//            ->setTemplateOptions(['area' => 'frontend', 'store' => 1])
//            ->setTemplateVars($emailTemplateVariables)
//            ->setFrom(['email' => 'sender@example.com', 'name' => 'Sender Name'])
//            ->addTo('ansarianas3115@example.com')
//            ->getTransport();
//
//        $transport->sendMessage();
//        $this->inlineTranslation->resume();
//
//        // Redirect or display a success message to the customer
//        // ...
//        $this->messageManager->addSuccessMessage(__('Email sent successfully.'));
//        $redirect = $this->resultRedirectFactory->create();
//        $redirect->setPath('employee/form/index');
//        return $redirect;
        $emailTemplateVariables = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => $address,
        ];
        $this->inlineTranslation->suspend();
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('custom_email_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => 1])
            ->setTemplateVars($emailTemplateVariables)
            ->setFrom(['email' => 'mohammadanas208023@gmail.com', 'name' => 'Anas'])
            ->addTo('danishrazik2001@gmail.com')
            ->getTransport();

        $transport->sendMessage();
        $this->inlineTranslation->resume();

        $this->messageManager->addSuccessMessage(__('Email sent successfully.'));
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('employee/form/index');
        return $redirect;

    }
}
