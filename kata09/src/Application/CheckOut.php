<?php

namespace App\Application;

use App\Infrastructure\MarketPricingRules;

class CheckOut
{


    /**
     * @var string[]
     */
    private $items = [];

    public function __construct(private PriceSchemeCalculator $pricingRules, private MarketPricingRules $marketRules)
    {

    }

    public function scan(string $items): void
    {

        $this->items[] = $items;

    }

    public function total(): float
    {
        return $this->pricingRules->getPrice($this->items,$this->marketRules);
    }
}