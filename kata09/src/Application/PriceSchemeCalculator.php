<?php

namespace App\Application;

use App\Domain\MarketPricingRulesInterface;

interface PriceSchemeCalculator
{
    public function getPrice(array $items, MarketPricingRulesInterface $marketPricingRules): float;
}