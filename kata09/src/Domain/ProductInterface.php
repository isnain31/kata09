<?php

namespace App\Domain;

interface ProductInterface
{
    function addSpecialPrice(SpecialPricingScheme $specialPrice);
}