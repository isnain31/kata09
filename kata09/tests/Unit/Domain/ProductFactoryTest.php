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
        $productAPricingScheme=new MultiPricePriceScheme(3, 130,1);
        $product=ProductFactory::create('A', 50, [$productAPricingScheme]);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('A', $product->getSku());
        $this->assertEquals(50, $product->getPrice());
        $this->assertIsArray($product->getSpecialPrice());
        $specialPrice=$product->getSpecialPrice()[0];
        $this->assertInstanceOf(MultiPricePriceScheme::class, $specialPrice);
        $this->assertEquals(3, $specialPrice->getQuantity());
        $this->assertEquals(130, $specialPrice->getPrice());
        $this->assertEquals(1, $specialPrice->getPriority());
    }


    public function testPriorityOnCreate()
    {
        $productAPricingSchemeTwo=new MultiPricePriceScheme(3, 130,2);
        $productAPricingSchemeOne=new MultiPricePriceScheme(5, 120,1);

        $product=ProductFactory::create('A', 50, [$productAPricingSchemeTwo, $productAPricingSchemeOne]);

        $this->assertIsArray($product->getSpecialPrice());
        $specialPrice=$product->getSpecialPrice()[0];
        $this->assertInstanceOf(MultiPricePriceScheme::class, $specialPrice);
        $this->assertEquals(3, $specialPrice->getQuantity());
        $this->assertEquals(130, $specialPrice->getPrice());
        $this->assertEquals(2, $specialPrice->getPriority());

        $specialPrice=$product->getSpecialPrice()[1];
        $this->assertInstanceOf(MultiPricePriceScheme::class, $specialPrice);
        $this->assertEquals(5, $specialPrice->getQuantity());
        $this->assertEquals(120, $specialPrice->getPrice());
        $this->assertEquals(1, $specialPrice->getPriority());
    }
}