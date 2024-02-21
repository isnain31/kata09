<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Product;
use App\Domain\ProductFactory;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use Codeception\Test\Unit;

class ProductFactoryTest extends Unit
{
    public function testCreate()
    {
        $productAPricingScheme=new MultiPricePriceScheme(3, 130);
        $product=ProductFactory::create('A', 50, $productAPricingScheme);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('A', $product->getSku());
        $this->assertEquals(50, $product->getPrice());
        $this->assertEquals($productAPricingScheme, $product->getSpecialPrice());

    }
}