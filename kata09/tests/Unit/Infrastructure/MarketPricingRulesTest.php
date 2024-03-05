<?php

namespace App\Tests\Unit\Infrastructure;

use App\Domain\ProductFactory;
use App\Infrastructure\MarketPricingRules;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use Codeception\Test\Unit;

class MarketPricingRulesTest extends Unit
{
    public function testAddRuleByProduct()
    {
        $marketRules= new MarketPricingRules();
        $marketRules->addRuleByProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));
        $marketRules->addRuleByProduct(ProductFactory::create('B', 20));

        $this->assertEquals(10,$marketRules->getRuleByProductSku('A')->getPrice());
        $this->assertEquals(20,$marketRules->getRuleByProductSku('B')->getPrice());
    }


}