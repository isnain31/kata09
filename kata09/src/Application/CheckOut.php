<?php

namespace App\Application;

use App\Domain\ProductCatalogInterface;
use App\Infrastructure\ProductCatalog;

class CheckOut
{


    /**
     * @var string[]
     */
    private $items = [];

    public function __construct(private PriceSchemeCalculatorInterface $pricingRules, private ProductCatalogInterface $catalog)
    {

    }

    public function scan(string $items): void
    {

        $this->items[] = $items;

    }

    public function total(): float
    {
        return $this->pricingRules->getPrice($this->items,$this->catalog);
    }
}