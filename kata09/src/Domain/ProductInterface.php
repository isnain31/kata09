<?php

namespace App\Domain;

interface ProductInterface
{
    function addSpecialPrice(SpecialPricingScheme $specialPrice);
    public function getSku(): string;
    public function getPrice(): float;
}