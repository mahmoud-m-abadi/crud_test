<?php

namespace App\Providers;

use App\Domains\Customer\Application\Create\CreateCustomerCommandHandler;
use App\Domains\Customer\Application\Delete\DeleteCustomerByIdCommandHandler;
use App\Domains\Customer\Application\Get\GetCustomerByIdQueryHandler;
use App\Domains\Customer\Application\Listing\SearchCustomersQueryHandler;
use App\Domains\Customer\Application\Subscriber\CreatedCustomerSubscriber;
use App\Domains\Customer\Application\Subscriber\UpdatedCustomerSubscriber;
use App\Domains\Customer\Application\Update\UpdateCustomerCommandHandler;
use App\Domains\Customer\Domain\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Domains\Customer\Infrastructure\CustomerRepository as EloquentCustomerRepository;

class BroadcastServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class
        );

        /**************** QUERY AND COMMANDS *****************/
        $this->app->tag(
            CreateCustomerCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            DeleteCustomerByIdCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            GetCustomerByIdQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            SearchCustomersQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            UpdateCustomerCommandHandler::class,
            'command_handler'
        );

        /***************** EVENTS ***************/
        $this->app->tag(
            CreatedCustomerSubscriber::class,
            'domain_event_subscriber'
        );

        $this->app->tag(
            UpdatedCustomerSubscriber::class,
            'domain_event_subscriber'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
