<?php

namespace App\Domain;

interface MarketPricingRulesInterface
{
    public function addRuleByProduct(ProductInterface $product): void;
    public function getRuleByProductSku(string $sku): ProductInterface;
}