<?php
namespace App\Tests\Unit\Application;

use App\Application\CheckOut;
use App\Domain\ProductFactory;
use App\Infrastructure\MarketPricingRules;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePriceSchemeCalculator;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class CheckoutTest extends Unit
{
    private CheckOut $checkout;
    private MultiPricePriceSchemeCalculator $pricingRules;

    private MarketPricingRules $marketPricingRules;

    protected function _before()
    {

        $this->marketPricingRules = new MarketPricingRules();
        $this->marketPricingRules->addRuleByProduct(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));
        $this->marketPricingRules->addRuleByProduct(ProductFactory::create('B', 30, [new MultiPricePriceScheme(2, 45,1)]));
        $this->marketPricingRules->addRuleByProduct(ProductFactory::create('C', 20));
        $this->marketPricingRules->addRuleByProduct(ProductFactory::create('D', 15));

        $this->pricingRules = new MultiPricePriceSchemeCalculator();
    }

    // tests

    public function testTotals()
    {
        $this->Price('');
        $this->assertEquals(0, $this->checkout->total());
        $this->Price('A');
        $this->assertEquals(50, $this->checkout->total());
        $this->Price('AB');
        $this->assertEquals(80, $this->checkout->total());
        $this->Price('CDBA');
        $this->assertEquals(115, $this->checkout->total());

        $this->Price('AA');
        $this->assertEquals(100, $this->checkout->total());
        $this->Price('AAA');
        $this->assertEquals(130, $this->checkout->total());
        $this->Price('AAAA');
        $this->assertEquals(180, $this->checkout->total());
        $this->Price('AAAAA');
        $this->assertEquals(230, $this->checkout->total());
        $this->Price('AAAAAA');
        $this->assertEquals(260, $this->checkout->total());

        $this->Price('AAAB');
        $this->assertEquals(160, $this->checkout->total());
        $this->Price('AAABB');
        $this->assertEquals(175, $this->checkout->total());
        $this->Price('AAABBD');
        $this->assertEquals(190, $this->checkout->total());
        $this->Price('DABABA');
        $this->assertEquals(190, $this->checkout->total());
    }


    public function testTotalIncremental()
    {
        $this->checkout = new CheckOut( $this->pricingRules, $this->marketPricingRules);
        $this->assertEquals(0, $this->checkout->total());
        $this->checkout->scan('A');$this->assertEquals(50, $this->checkout->total());
        $this->checkout->scan('B');$this->assertEquals(80, $this->checkout->total());
        $this->checkout->scan('A');$this->assertEquals(130, $this->checkout->total());
        $this->checkout->scan('A');$this->assertEquals(160, $this->checkout->total());
        $this->checkout->scan('B');$this->assertEquals(175, $this->checkout->total());
    }

    private function Price(string $goods): void
    {
        $this->checkout = new CheckOut($this->pricingRules, $this->marketPricingRules);

        foreach(str_split($goods)  as $item ) {
            $this->checkout->scan($item);
        }

    }
}
