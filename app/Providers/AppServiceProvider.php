<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\SellerRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TicketRepositoryInterface::class,
            TicketRepository::class
        );

        $this->app->bind(
            SellerRepositoryInterface::class,
            SellerRepository::class
        );
    }

    public function boot()
    {
        //
    }
}