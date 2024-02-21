<?php

namespace App\Infrastructure\MultiplePricing;

use App\Domain\SpecialPricingSchemeInterface;

class MultiPricePriceScheme implements SpecialPricingSchemeInterface
{
    const   SPECIAL_PRICE_TYPE = 'multi_price';
    public function __construct( private int $quantity, private float $price)
    {

    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

}