<?php

namespace App\Infrastructure\MultiplePricing;

use App\Application\PriceSchemeCalculatorInterface;
use App\Domain\ProductCatalogInterface;

class MultiPricePriceSchemeCalculatorInterface implements PriceSchemeCalculatorInterface
{


    public function getPrice(array $items, ProductCatalogInterface $catalog): float
    {
        $total=0;
        $items = array_count_values($items);
        foreach ($items as $item => $quantity) {
            $total += $this->calculate($item, $quantity, $catalog);
        }

        return $total;

    }

    private function calculate(string $sku, int $quantity, ProductCatalogInterface $catalog): float
    {

        $price = 0;
        $specialPrices= $catalog->getProductBySku($sku)->getSpecialPrice();

        foreach($specialPrices as $specialPrice){

            if(!$specialPrice instanceof MultiPricePriceScheme)
                continue;

            $price += $specialPrice->getPrice() * intdiv($quantity, $specialPrice->getQuantity());
            $quantity = $quantity % $specialPrice->getQuantity();
        }

        return $price + $quantity*$catalog->getProductBySku($sku)->getPrice();
    }



}