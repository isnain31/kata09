<?php

namespace App\Application;

use App\Domain\ProductCatalogInterface;

interface PriceSchemeCalculatorInterface
{
    public function getPrice(array $items, ProductCatalogInterface $catalog): float;
}