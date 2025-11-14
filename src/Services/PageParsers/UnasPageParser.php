<?php

namespace Molitor\ProductScraper\Services\PageParsers;

use Carbon\Carbon;
use Molitor\HtmlParser\HtmlParser;
use Molitor\Product\Dto\ProductDto;
use Molitor\Scraper\Services\PageParser;

class UnasPageParser extends PageParser
{

    public function getType(HtmlParser $html): string
    {
        return 'product';
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
        $product = new ProductDto();

        return [
            'product' => $product,
        ];
    }
}
