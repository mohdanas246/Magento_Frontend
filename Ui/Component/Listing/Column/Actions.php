<?php

namespace Codilar\Employee\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
/**
 * Class Actions
 */
class Actions extends Column
{
    private UrlInterface $url;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $url
     * @param array              $components
     * @param array              $data
     */
    public function  __construct(ContextInterface $context,UrlInterface $url, UiComponentFactory $uiComponentFactory,
                                 array $components = [],
                                 array $data = [])
    {
        $this->url = $url;
        parent::__construct($context,$uiComponentFactory,$components, $data);
    }
    /**
     * Prepare Data Source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                // here we can also use the data from $item to configure some parameters of an action URL
                $item[$this->getData('first_name')] = [
                    'edit' => [
                        'href' => $this->url->getUrl('employee/index/save',['employee_id' => $item['employee_id']] ),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->url->getUrl('employee/index/delete',['employee_id' => $item['employee_id']] ),
                        'label' => __('delete')
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
