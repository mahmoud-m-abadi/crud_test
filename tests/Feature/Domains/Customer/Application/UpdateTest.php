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

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_update_a_customer_on_not_found(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(CustomerNotFound::class);

        $customer = CustomerModel::factory()->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $this->patchJson(
            route('customers.update', fake()->numberBetween(1,55)),
            [
                CustomerModel::FIRST_NAME => $name = fake()->name(),
                CustomerModel::LAST_NAME => $customer->{CustomerModel::LAST_NAME},
                CustomerModel::PHONE_NUMBER => $customer->{CustomerModel::PHONE_NUMBER},
                CustomerModel::EMAIL => $customer->{CustomerModel::EMAIL},
                CustomerModel::DATE_OF_BIRTH => $customer->{CustomerModel::DATE_OF_BIRTH},
                CustomerModel::BANK_ACCOUNT_NUMBER => $customer->{CustomerModel::BANK_ACCOUNT_NUMBER},
            ]
        );
    }

    public function test_update_a_customer_successfully(): void
    {
        $this->withoutExceptionHandling();

        $customer = CustomerModel::factory()->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $response = $this->patchJson(
            route('customers.update', $customer->id),
            [
                CustomerModel::FIRST_NAME => $name = fake()->name(),
                CustomerModel::LAST_NAME => $customer->{CustomerModel::LAST_NAME},
                CustomerModel::PHONE_NUMBER => $customer->{CustomerModel::PHONE_NUMBER},
                CustomerModel::EMAIL => $customer->{CustomerModel::EMAIL},
                CustomerModel::DATE_OF_BIRTH => $customer->{CustomerModel::DATE_OF_BIRTH},
                CustomerModel::BANK_ACCOUNT_NUMBER => $customer->{CustomerModel::BANK_ACCOUNT_NUMBER},
            ]
        );

        $response->assertOk()
            ->assertJsonPath('first_name', $name)
            ->assertJsonPath('last_name',  $customer->{CustomerModel::LAST_NAME});
    }
}
