<?php

namespace App\Infrastructure\MultiplePricing;

use App\Application\PricingRulesInterface;
use app\Domain\Product;

class MultiPricePricingCalculationRules implements PricingRulesInterface
{

    private array $rules = [];

    public function add(Product $product): void
    {
        $this->rules[$product->getSku()] = $product;
    }

    public function getPrice(array $items): float
    {
        $total=0;
        $items = array_count_values($items);
        foreach ($items as $item => $quantity) {
            $total += $this->calculate($item, $quantity);
        }

        return $total;

    }

    private function calculate(string $sku, int $quantity): float
    {
        if (!isset($this->rules[$sku]))
            return 0;

        $price = 0;
        $specialPrice= $this->rules[$sku]->getSpecialPrice();
        if($specialPrice instanceof MultiPricePriceScheme){
            $price += $specialPrice->getPrice() * intdiv($quantity, $specialPrice->getQuantity());
            $quantity = $quantity % $specialPrice->getQuantity();
        }
        return $price + $quantity*$this->getNormalPrice($sku);
    }

    private function getNormalPrice(string $sku): float
    {
        return $this->rules[$sku]->getPrice();
    }



}