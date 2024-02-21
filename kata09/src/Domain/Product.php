<?php

namespace App\Domain;

class Product implements ProductInterface
{


    private SpecialPricingSchemeInterface $specialPrice;

    public function __construct(private string $sku, private float $price)
    {
        $this->specialPrice = new NullSpecialPrice();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setSpecialPrice(SpecialPricingSchemeInterface $specialPrice): void
    {
            $this->specialPrice = $specialPrice;
    }

    public function getSpecialPrice(): SpecialPricingSchemeInterface
    {
        return $this->specialPrice;
    }

}