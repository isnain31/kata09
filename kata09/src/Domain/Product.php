<?php

namespace App\Domain;

class Product implements ProductInterface
{


    /*
     * @var SpecialPricingSchemeInterface[]
     */
    private array $specialPrice;

    public function __construct(private string $sku, private float $price)
    {
        $this->specialPrice = [];
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
            $this->specialPrice[] = $specialPrice;
            usort($this->specialPrice, function($a, $b){
                return $a->getPriority() < $b->getPriority();
            });
    }

    /**
     * @return SpecialPricingScheme[]
     */
    public function getSpecialPrice(): array
    {
        return $this->specialPrice;
    }

}