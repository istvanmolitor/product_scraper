<?php

namespace Molitor\ProductScraper\Services\PageParsers;

use Molitor\HtmlParser\HtmlParser;
use Molitor\Product\Dto\ImageDto;
use Molitor\Product\Dto\ProductAttributeDto;
use Molitor\Product\Dto\ProductCategoryDto;
use Molitor\Product\Dto\ProductDto;
use Molitor\Product\Dto\ProductFieldDto;
use Molitor\Product\Dto\ProductFieldOptionDto;

class UnasPageParser extends ProductPageParser
{
    public function isProductPage(HtmlParser $html): bool
    {
        $meta = $html->parseMetaData();
        return isset($meta['og:type']) and $meta['og:type'] === 'product';
    }

    public function fillProduct(ProductDto $product, HtmlParser $html): void
    {
        $product->active = true;

        $language = 'hu';


        foreach ($html->getLinkedData() as $linkedData) {
            if ($linkedData['@type'] === 'Product') {
                $product->sku = $linkedData['sku'];
                $product->name->set($language, $linkedData['name']);
                $product->description->set($language, $linkedData['description']);
                $product->price = $linkedData['offers']['price'];
                $product->currency = $linkedData['offers']['priceCurrency'];
                $product->url = $linkedData['url'];
                $product->slug = parse_url($linkedData['url'], PHP_URL_PATH);
                $product->productUnit->name->set($language, 'darab');

                $i = 0;
                foreach ($linkedData['additionalProperty'] as $additionalProperty) {
                    if($additionalProperty['@type'] === 'PropertyValue') {

                        $field = new ProductFieldDto();
                        $field->name->set($language, $additionalProperty['name']);

                        $option = new ProductFieldOptionDto();
                        $option->name->set($language, $additionalProperty['value']);

                        $attribute = new ProductAttributeDto($field, $option, $i);
                        $product->addAttribute($attribute);
                        $i++;
                    }
                }

                foreach ($linkedData['image'] as $imageUrl) {
                    $imageDto = new ImageDto();
                    $imageDto->url = $imageUrl;
                    $product->addImage($imageDto);
                }

            }
            elseif ($linkedData['@type'] === 'BreadcrumbList') {
                $categoryPath = [];
                foreach ($linkedData['itemListElement'] as $category) {
                    $categoryPath[] = $category['name'];
                }
                $categoryDto = new ProductCategoryDto();
                $categoryDto->path->set($language, implode('/', $categoryPath));
                $product->addCategory($categoryDto);
            }
        }
    }
}
