<?php

namespace App\Tests\Unit\Infrastructure\MultiplePricing;

use App\Domain\ProductFactory;
use App\Infrastructure\ProductCatalog;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePriceSchemeCalculatorInterface;
use Codeception\Test\Unit;

class MultiPricePriceSchemeCalculatorTest extends Unit
{


    public function testGetPriceWhenProductHasSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculatorInterface();
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));

        $this->assertEquals(130,$pricingRules->getPrice(['A','A','A'],$catalog));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculatorInterface();
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(85,$pricingRules->getPrice(['A','A','A','A','A','A','A','A','A','A'],$catalog));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingLowQuantityHighPriority()
    {
        $pricingRules = new MultiPricePriceSchemeCalculatorInterface();
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(45,$pricingRules->getPrice(['A','A','A','A','A'],$catalog));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingHighQuantityHighPriority()
    {
        $pricingRules = new MultiPricePriceSchemeCalculatorInterface();
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,2),
            new MultiPricePriceScheme(3, 25,1)
        ]));

        $this->assertEquals(50,$pricingRules->getPrice(['A','A','A','A','A','A'],$catalog));
    }

    public function testGetPriceWhenProductHasNoSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculatorInterface();
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 50));

        $this->assertEquals(150,$pricingRules->getPrice(['A','A','A'],$catalog));
    }
}