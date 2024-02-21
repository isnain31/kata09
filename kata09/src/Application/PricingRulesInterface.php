<?php

namespace App\Application;

use app\Domain\Product;

interface PricingRulesInterface
{
    public function getPrice(array $items): float;
    public function add(Product $product): void;
}