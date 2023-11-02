<?php

namespace Codilar\Employee\Plugins;

class Product
{
    public function afterGetName(\Magento\Catalog\Model\Product $product, $name)
    {
       $price = $product->getData('price');
//        $name = $product->getData('name');
//          $name .= " Anas";
        if($price <60){
            $name .= "So cheep";
        }
        else{
            $name .= "So bloody extensive";
        }
        return $name;
    }
}
