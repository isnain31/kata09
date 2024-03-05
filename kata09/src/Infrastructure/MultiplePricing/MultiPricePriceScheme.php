<?php

namespace App\Infrastructure\MultiplePricing;

use App\Domain\SpecialPricingScheme;

class MultiPricePriceScheme extends SpecialPricingScheme
{

    public function __construct( private int $quantity, private float $price, int $priority)
    {
        $this->setPriority($priority);
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPriority(int $priority): void
    {
       $this->priority= $priority;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}