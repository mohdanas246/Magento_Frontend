<?php

namespace Codilar\Employee\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Codilar\Employee\Model\ResourceModel\Form\CollectionFactory;
use Codilar\Employee\Model\ResourceModel\Form as ResourceModel;
use Codilar\Employee\Model\FormFactory;
class Form extends  Template
{
    public CollectionFactory $collection;
    private ResourceModel $resouceModel;
    private FormFactory $formFactory;

    public function __construct(Context $context,
                                CollectionFactory $collection,
                                ResourceModel     $resourceModel,
                                FormFactory       $formFactory,
                                array             $data = [])
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
        $this->resouceModel = $resourceModel;
        $this->formFactory = $formFactory;
    }
    public function getCollection()
    {
        return $this->collection->create();
    }
    public function getDeleteAction()
    {
        return $this->getUrl('employee/form/delete',['_secure' => true]);
    }
    public function getEditAction()
    {
        return $this->getUrl('employee/form/edit',['_secure' => true]);
    }
    public function getLoadValue()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->formFactory->create();
        $this->resouceModel->load($model,$id);
        return $model;
    }
}
