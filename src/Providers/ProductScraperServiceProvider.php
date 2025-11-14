<?php

namespace Molitor\ProductScraper\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Molitor\ProductScraper\Services\ProductScraperSettingForm;
use Molitor\Scraper\Events\ScraperUrlUpdateEvent;
use Molitor\ProductScraper\Listeners\ScraperUrlUpdateListener;
use Molitor\Setting\Services\SettingHandlerService;

class ProductScraperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            ScraperUrlUpdateEvent::class,
            ScraperUrlUpdateListener::class
        );

        $this->app->make(SettingHandlerService::class)
            ->register(ProductScraperSettingForm::class);
    }

    public function register()
    {
    }
}
