<?php

namespace App\Tests\Unit\Infrastructure\MultiplePricing;

use App\Domain\ProductFactory;
use App\Infrastructure\MarketPricingRules;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePriceSchemeCalculator;
use Codeception\Test\Unit;

class MultiPricePriceSchemeCalculatorTest extends Unit
{


    public function testGetPriceWhenProductHasSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculator();
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));

        $this->assertEquals(130,$pricingRules->getPrice(['A','A','A'],$marketRules));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculator();
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(85,$pricingRules->getPrice(['A','A','A','A','A','A','A','A','A','A'],$marketRules));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingLowQuantityHighPriority()
    {
        $pricingRules = new MultiPricePriceSchemeCalculator();
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));

        $this->assertEquals(45,$pricingRules->getPrice(['A','A','A','A','A'],$marketRules));
    }

    public function testGetPriceWhenProductHasMultipleSpecialPricePriorityTestingHavingHighQuantityHighPriority()
    {
        $pricingRules = new MultiPricePriceSchemeCalculator();
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,2),
            new MultiPricePriceScheme(3, 25,1)
        ]));

        $this->assertEquals(50,$pricingRules->getPrice(['A','A','A','A','A','A'],$marketRules));
    }

    public function testGetPriceWhenProductHasNoSpecialPrice()
    {
        $pricingRules = new MultiPricePriceSchemeCalculator();
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 50));

        $this->assertEquals(150,$pricingRules->getPrice(['A','A','A'],$marketRules));
    }
}