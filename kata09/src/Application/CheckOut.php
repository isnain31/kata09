<?php

namespace App\Application;

class CheckOut
{

    /**
     * @var string[]
     */
    private $items = [];

    public function __construct(private PricingRulesInterface $pricingRules)
    {

    }

    public function scan(string $items): void
    {

        $this->items[] = $items;

    }

    public function total(): float
    {
        return $this->pricingRules->getPrice($this->items);
    }
}