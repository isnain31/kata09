<?php

namespace App\Infrastructure;

use App\Domain\MarketPricingRulesInterface;
use App\Domain\NullProduct;
use App\Domain\Product;
use App\Domain\ProductInterface;

class MarketPricingRules implements MarketPricingRulesInterface
{
    /**
     * @var Product[]
     */
    private array $products;


    public function addRuleByProduct(ProductInterface $product): void
    {
        $this->products[$product->getSku()] = $product;
    }


    public function getRuleByProductSku(string $sku): ProductInterface
    {
        return $this->products[$sku]??new NullProduct();
    }
}