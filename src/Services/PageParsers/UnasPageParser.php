<?php

namespace Molitor\ProductScraper\Services\PageParsers;

use Molitor\HtmlParser\HtmlParser;
use Molitor\Product\Dto\ProductDto;

class UnasPageParser extends ProductPageParser
{
    public function isProductPage(HtmlParser $html): bool
    {
        $meta = $html->parseMetaData();
        return isset($meta['og:type']) and $meta['og:type'] === 'product';
    }

    public function fillProduct(ProductDto $product, HtmlParser $html): void
    {
        $language = 'hu';

        $sku = $html->pregMatch('/UNAS\.shop\["sku"\]="([^"]+)"/');
        $name = $html->getByTagName('h1')->getText();

        $product->sku = $sku;
        $product->name->set($language, $name);
    }
}
