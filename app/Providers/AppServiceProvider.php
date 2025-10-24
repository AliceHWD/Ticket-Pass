<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\SellerRepository;
use App\Repositories\TicketRepository;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;

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

        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\PaymentRepositoryInterface::class,
            \App\Repositories\PaymentRepository::class
        );
    }

    public function boot()
    {
        //
    }
}