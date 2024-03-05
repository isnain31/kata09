<?php

namespace App\Domain;

class NullProduct implements ProductInterface
{


    public function __construct(private string $sku="", private float $price=0.0)
    {
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function addSpecialPrice(SpecialPricingScheme $specialPrice): void
    {
    }

    /**
     * @return SpecialPricingScheme[]
     */
    public function getSpecialPrice(): array
    {
        return [];
    }

}