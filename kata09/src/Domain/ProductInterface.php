<?php

namespace App\Domain;

interface ProductInterface
{
    function setSpecialPrice(SpecialPricingSchemeInterface $specialPrice);
}