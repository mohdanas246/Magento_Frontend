<?php
namespace Codilar\Employee\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Form\FormKey;
class AddToCartObserver implements ObserverInterface
{
    protected ScopeConfigInterface $scopeConfig;
    protected ProductRepositoryInterface $productRepository;
    protected FormKey $formkey;

    public function __construct(
        ScopeConfigInterface       $scopeConfig,
        ProductRepositoryInterface $productRepository,
        FormKey                    $formKey,
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->formkey = $formKey;
    }

    /**
     * @throws \Zend_Log_Exception
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        try {
            /**
             * @var \Magento\Checkout\Model\Cart $cart
             */
            $cart = $observer->getEvent()->getCart();

            $productSku = $this->getConfigProductSku();
            $needToAdd = true;
            if ($productSku)
            {
                $items = $cart->getQuote()->getItems();
                foreach ($items as $item) {
                    if ($item->getSku() == $productSku || $item->isDeleted()) {
                        $needToAdd = false;
                    }
                }
                $product = $this->getProductBySku($productSku);
                if (!empty($product) && $needToAdd) {
                    $params = array(
                        'form_key' => $this->formkey->getFormKey(),
                        'product' => $product->getId(),
                        'qty'   =>1
                    );
                    $logger->info("product ". $product->getSku());
                    $cart->addProduct($product, $params);
                }
            }
        }catch (\Exception $exception) {
            $logger->info($exception->getMessage());
        }
    }
    protected function getConfigProductSku()
    {
        $configValue = $this->scopeConfig->getValue(
            'Codilar_Employee/product_settings/sku',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $configValue;
    }
    protected function getProductBySku($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
            return $product;
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
