<?php

namespace Codilar\Employee\Controller\Form;

use Codilar\Employee\Model\FormFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

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
