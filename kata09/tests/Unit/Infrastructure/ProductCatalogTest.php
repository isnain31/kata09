<?php

namespace App\Tests\Unit\Infrastructure;

use App\Domain\ProductFactory;
use App\Infrastructure\ProductCatalog;
use App\Infrastructure\MultiplePricing\MultiPricePriceScheme;
use Codeception\Test\Unit;

class ProductCatalogTest extends Unit
{
    public function testAddRuleByProduct()
    {
        $catalog= new ProductCatalog();
        $catalog->addProduct(ProductFactory::create('A', 10, [
            new MultiPricePriceScheme(5, 40,1),
            new MultiPricePriceScheme(3, 25,2)
        ]));
        $catalog->addProduct(ProductFactory::create('B', 20));

        $this->assertEquals(10,$catalog->getProductBySku('A')->getPrice());
        $this->assertEquals(20,$catalog->getProductBySku('B')->getPrice());
    }


}