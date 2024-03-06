<?php

namespace App\Domain;

interface ProductCatalogInterface
{
    public function addProduct(ProductInterface $product): void;
    public function getProductBySku(string $sku): ProductInterface;
}