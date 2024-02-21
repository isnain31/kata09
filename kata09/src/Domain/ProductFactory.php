<?php

namespace App\Domain;

class ProductFactory
{
    /**
     * @param string $item
     * @param float $price
     * @param SpecialPricingSchemeInterface $pricingSchemes
     * @return Product
     */
    public static function create(string $item, float $price, SpecialPricingSchemeInterface $pricingScheme=null): Product
    {
         $product=new Product($item, $price);
         if($pricingScheme)
            $product->setSpecialPrice($pricingScheme);

         return $product;
    }
}