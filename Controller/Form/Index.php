<?php

namespace Codilar\Employee\Controller\Form;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;


class Index implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;


    public function __construct(
        PageFactory $resultPageFactory,

    )
    {
        $this->resultPageFactory = $resultPageFactory;

    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
