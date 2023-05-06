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

class GetTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_get_not_found_customer(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(HandlerFailedException::class);

        $this->getJson(route('customers.show', fake()->numberBetween(1,2)));
    }

    public function test_get_customer_successfully(): void
    {
        $this->withoutExceptionHandling();

        $customer = CustomerModel::factory()->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $response = $this->getJson(route('customers.show', $customer->id));

        $response->assertOk()
            ->assertJsonStructure(['customer' => [CustomerModel::ID, CustomerModel::FIRST_NAME, CustomerModel::LAST_NAME]]);
    }
}
