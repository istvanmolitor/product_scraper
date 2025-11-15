<?php

namespace Molitor\ProductScraper\Services\PageParsers;

use Carbon\Carbon;
use Molitor\HtmlParser\HtmlParser;
use Molitor\Product\Dto\ProductDto;
use Molitor\Scraper\Services\PageParser;

abstract class ProductPageParser extends PageParser
{
    public function getType(HtmlParser $html): string
    {
        if($this->isProductPage($html)) {
            return 'product';
        }
        return 'page';
    }

    public function getPriority(HtmlParser $html, string $type): int
    {
        return 1;
    }

    function getExpiration(HtmlParser $html, string $type, int $priority): Carbon
    {
        return Carbon::now()->addDays(1);
    }

    public function getData(HtmlParser $html, string $type): array
    {
        if($type === 'product') {
            $product = new ProductDto();
            $this->fillProduct($product, $html);
            return [
                'product' => $product,
            ];
        }
        else {
            return [];
        }
    }

    abstract public function isProductPage(HtmlParser $html): bool;

    abstract public function fillProduct(ProductDto $product, HtmlParser $html): void;
}
