<?php

namespace App\Infrastructure\MultiplePricing;

use App\Application\PriceSchemeCalculator;
use App\Domain\MarketPricingRulesInterface;

class MultiPricePriceSchemeCalculator implements PriceSchemeCalculator
{


    public function getPrice(array $items, MarketPricingRulesInterface $marketPricingRules): float
    {
        $total=0;
        $items = array_count_values($items);
        foreach ($items as $item => $quantity) {
            $total += $this->calculate($item, $quantity, $marketPricingRules);
        }

        return $total;

    }

    private function calculate(string $sku, int $quantity, MarketPricingRulesInterface $marketPricingRules): float
    {

        $price = 0;
        $specialPrices= $marketPricingRules->getRuleByProductSku($sku)->getSpecialPrice();

        foreach($specialPrices as $specialPrice){
            $price += $specialPrice->getPrice() * intdiv($quantity, $specialPrice->getQuantity());
            $quantity = $quantity % $specialPrice->getQuantity();
        }

        return $price + $quantity*$marketPricingRules->getRuleByProductSku($sku)->getPrice();
    }



}