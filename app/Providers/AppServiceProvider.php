<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\SellerRepository;
use App\Repositories\TicketRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            EventRepositoryInterface::class,
            EventRepository::class
        );

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