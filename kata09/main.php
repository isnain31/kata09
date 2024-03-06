<?php
require __DIR__ . '/vendor/autoload.php';

use App\Application\CheckOut;
use App\Domain\ProductFactory;
use App\Infrastructure\ProductCatalog;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use App\Infrastructure\MultiplePricing\MultiPricePriceSchemeCalculatorInterface;

$catalog=new ProductCatalog();


$catalog->addProduct(ProductFactory::create('A', 50, [new MultiPricePriceScheme(3, 130,1)]));
$catalog->addProduct(ProductFactory::create('B', 30, [new MultiPricePriceScheme(2, 45,1)]));
$catalog->addProduct(ProductFactory::create('C', 20));
$catalog->addProduct(ProductFactory::create('D', 15));


$priceCalculator = new MultiPricePriceSchemeCalculatorInterface();


$checkOut = new CheckOut($priceCalculator,$catalog);

$checkOut->scan('C');
$checkOut->scan('D');
$checkOut->scan('B');
$checkOut->scan('A');

echo "for the scanning sequce CDBA the total price is: \n";
echo $checkOut->total()."\n";