<?php

namespace Molitor\ProductScraper\Listeners;

use Molitor\Customer\Repositories\CustomerRepositoryInterface;
use Molitor\CustomerProduct\Services\Dto\CustomerProductDtoService;
use Molitor\Scraper\Events\ScraperUrlUpdateEvent;

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
            $product = $event->data['product'];

            $baseUrl = $event->scraperUrl->scraper->base_url;

            $customerRepository = app(CustomerRepositoryInterface::class);
            $customer = $customerRepository->findOrCrate(parse_url($baseUrl, PHP_URL_HOST));

            /** @var $customerProductDtoService */
            $customerProductDtoService = app(CustomerProductDtoService::class);
            $customerProductDtoService->saveDto($customer, $product);
        };
    }
}

