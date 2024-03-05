<?php
require __DIR__ . '/vendor/autoload.php';

use App\Application\CheckOut;
use App\Domain\ProductFactory;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePricingCalculationRules;


$pricingRules = new MultiPricePricingCalculationRules();

$pricingRules->add(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));
$pricingRules->add(ProductFactory::create('B', 30, [new MultiPricePriceScheme(2, 45,1)]));
$pricingRules->add(ProductFactory::create('C', 20));
$pricingRules->add(ProductFactory::create('D', 15));

$checkOut = new CheckOut($pricingRules);

$checkOut->scan('C');
$checkOut->scan('D');
$checkOut->scan('B');
$checkOut->scan('A');

echo "for the scanning sequce CDBA the total price is: \n";
echo $checkOut->total()."\n";