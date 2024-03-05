<?php

namespace App\Domain;

class ProductFactory
{
    /**
     * @param string $item
     * @param float $price
     * @param SpecialPricingScheme[] $pricingSchemes
     * @return Product
     */
    public static function create(string $item, float $price, array $pricingSchemes=[]): Product
    {
         $product=new Product($item, $price);

         foreach($pricingSchemes as $pricingScheme)
             $product->addSpecialPrice($pricingScheme);


         return $product;
    }
}