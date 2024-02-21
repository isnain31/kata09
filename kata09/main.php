<?php
require __DIR__ . '/vendor/autoload.php';

use App\Application\CheckOut;
use App\Domain\ProductFactory;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePricingCalculationRules;


$pricingRules = new MultiPricePricingCalculationRules();
$pricingRules->add(ProductFactory::create('A', 50, new MultiPricePriceScheme(3, 130)));
$pricingRules->add(ProductFactory::create('B', 30, new MultiPricePriceScheme(2, 45)));
$pricingRules->add(ProductFactory::create('C', 20));
$pricingRules->add(ProductFactory::create('D', 15));

$pricingRules = new CheckOut($pricingRules);

$pricingRules->scan('C');
$pricingRules->scan('D');
$pricingRules->scan('B');
$pricingRules->scan('A');

echo "for the scanning sequce CDBA the total price is: \n";
echo $pricingRules->total()."\n";