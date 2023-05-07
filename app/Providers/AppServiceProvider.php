<?php

namespace App\Providers;

use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Domains\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use App\Domains\Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use App\Domains\Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use App\Domains\Shared\Infrastructure\Services\GooglePhoneValidationInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            EventBusInterface::class,
            function ($app) {
                return new MessengerEventBus($app->tagged('domain_event_subscriber'));
            }
        );

        $this->app->bind(
            QueryBusInterface::class,
            function ($app) {
                return new MessengerQueryBus($app->tagged('query_handler'));
            }
        );

        $this->app->bind(
            CommandBusInterface::class,
            function ($app) {
                return new MessengerCommandBus($app->tagged('command_handler'));
            }
        );

        $this->app->singleton(
            GooglePhoneValidationInterface::class,
            function ($app) {
                return \libphonenumber\PhoneNumberUtil::getInstance();
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
