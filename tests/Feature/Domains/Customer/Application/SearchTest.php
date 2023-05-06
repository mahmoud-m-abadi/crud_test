<?php

namespace Tests\Feature\Domains\Customer\Application;

use App\Domains\Customer\Domain\CustomerAlreadyExists;
use App\Domains\Customer\Domain\CustomerNotFound;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\ValueObject\BankAccountValueObject;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_empty_customers_list(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson(
            route(
                'customers.index',
                ['wheres' => [CustomerModel::FIRST_NAME => '0']]
            )
        );
        $response->assertOk()
            ->assertJsonCount(0, 'customers');
    }

    public function test_get_customers_list_successfully(): void
    {
        $this->withoutExceptionHandling();

        $customers = CustomerModel::factory(10)->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $response = $this->getJson(
            route('customers.index',
            [
                'wheres' => [
                    CustomerModel::FIRST_NAME => $customers->first()->{CustomerModel::FIRST_NAME}
                ]
            ])
        );

        $response->assertOk()
            ->assertJsonPath('customers.0.first_name', $customers->first()->{CustomerModel::FIRST_NAME})
            ->assertJsonPath('customers.0.last_name', $customers->first()->{CustomerModel::LAST_NAME});
    }
}
