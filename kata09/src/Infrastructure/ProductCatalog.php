<?php

namespace App\Infrastructure;

use App\Domain\ProductCatalogInterface;
use App\Domain\NullProduct;
use App\Domain\Product;
use App\Domain\ProductInterface;

class ProductCatalog implements ProductCatalogInterface
{
    /**
     * @var ProductInterface[]
     */
    private array $products;


    public function addProduct(ProductInterface $product): void
    {
        $this->products[$product->getSku()] = $product;
    }


    public function getProductBySku(string $sku): ProductInterface
    {
        return $this->products[$sku]??new NullProduct();
    }
}