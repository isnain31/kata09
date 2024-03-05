<?php
require __DIR__ . '/vendor/autoload.php';

use App\Application\CheckOut;
use App\Domain\ProductFactory;
use App\Infrastructure\MarketPricingRules;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePriceSchemeCalculator;

$marketRules=new MarketPricingRules();


$marketRules->addRuleByProduct(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));
$marketRules->addRuleByProduct(ProductFactory::create('B', 30, [new MultiPricePriceScheme(2, 45,1)]));
$marketRules->addRuleByProduct(ProductFactory::create('C', 20));
$marketRules->addRuleByProduct(ProductFactory::create('D', 15));


$priceCalculator = new MultiPricePriceSchemeCalculator();


$checkOut = new CheckOut($priceCalculator,$marketRules);

$checkOut->scan('C');
$checkOut->scan('D');
$checkOut->scan('B');
$checkOut->scan('A');

echo "for the scanning sequce CDBA the total price is: \n";
echo $checkOut->total()."\n";