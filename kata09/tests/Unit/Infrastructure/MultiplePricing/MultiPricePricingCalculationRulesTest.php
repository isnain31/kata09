<?php

namespace App\Tests\Unit\Infrastructure\MultiplePricing;

use App\Domain\ProductFactory;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePricingCalculationRules;
use Codeception\Test\Unit;

class MultiPricePricingCalculationRulesTest extends Unit
{

    /*
    public function testAdd()
    {
        $product=ProductFactory::create('A', 50, new MultiPricePriceScheme(3, 130));
        $pricingRules = new MultiPricePricingCalculationRules();
        $refelction = new \ReflectionClass(MultiPricePricingCalculationRules::class);
        $var=$refelction->getProperty('rules');
        $var->setAccessible(true);
        $pricingRules ->add($product);
        $this->assertEquals(['A'=>$product], $var->getValue($pricingRules));

    } */

    public function testGetPriceWhenProductHasSpecialPrice()
    {
        $pricingRules = new MultiPricePricingCalculationRules();
        $pricingRules ->add(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));

        $this->assertEquals(130,$pricingRules->getPrice(['A','A','A']));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPrice()
    {
        $pricingRules = new MultiPricePricingCalculationRules();
        $pricingRules ->add(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(85,$pricingRules->getPrice(['A','A','A','A','A','A','A','A','A','A']));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingLowQuantityHighPriority()
    {
        $pricingRules = new MultiPricePricingCalculationRules();
        $pricingRules ->add(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(45,$pricingRules->getPrice(['A','A','A','A','A']));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingHighQuantityHighPriority()
    {
        $pricingRules = new MultiPricePricingCalculationRules();
        $pricingRules ->add(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,2),
            new MultiPricePriceScheme(3, 25,1)
        ]));

        $this->assertEquals(50,$pricingRules->getPrice(['A','A','A','A','A','A']));
    }

    public function testGetPriceWhenProductHasNoSpecialPrice()
    {
        $pricingRules = new MultiPricePricingCalculationRules();
        $pricingRules ->add(ProductFactory::create('A', 50));

        $this->assertEquals(150,$pricingRules->getPrice(['A','A','A']));
    }
}