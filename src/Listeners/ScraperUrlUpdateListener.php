<?php

namespace Molitor\ProductScraper\Listeners;

use Molitor\Scraper\Events\ScraperUrlUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScraperUrlUpdateListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScraperUrlUpdateEvent $event): void
    {
        if($event->scraperUrl->type == 'product') {
            dd($event->data['product']);
        };
    }
}

