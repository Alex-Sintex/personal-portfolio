<?php

namespace App\Providers;

use App\Events\CreateOrderEvent;
use App\Listeners\GenerateInvoiceListener;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app['events']->listen(CreateOrderEvent::class, GenerateInvoiceListener::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);

        // Schedule a command
        /*
        $schedule = app(Schedule::class);
        $schedule->command('make:order', ['user_id' => 1, 'amount' => 20])->hourly();
        */
    }
}
