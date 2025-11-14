<?php

namespace Molitor\ProductScraper\Services;

use Molitor\Setting\Services\SettingForm;

class ProductScraperSettingForm extends SettingForm
{

    public function getSlug(): string
    {
        return 'product_scraper';
    }

    public function getLabel(): string
    {
        return 'Termék scraper';
    }

    public function getForm(): array
    {
        return [];
    }

    public function getFormFields(): array
    {
        return [];
    }
}
