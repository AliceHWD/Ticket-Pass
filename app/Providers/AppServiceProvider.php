<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\TicketRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            TicketRepositoryInterface::class,
            TicketRepository::class
        );
    }

    public function boot()
    {
        //
    }
}