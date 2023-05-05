<?php

namespace Tests\Feature\Domains\Customer\Application;

use App\Domains\Customer\Infrastructure\CustomerModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_customer_successful(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH =>  fake()->date('Y-m-d'),
            CustomerModel::EMAIL => fake()->email(),
            CustomerModel::BANK_ACCOUNT_NUMBER =>  fake()->numberBetween(11111111,888888888),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure(['customer' => ['first_name', 'last_name']]);

        $this->assertDatabaseHas(
            CustomerModel::TABLE,
            [
                CustomerModel::FIRST_NAME => $data[CustomerModel::FIRST_NAME],
                CustomerModel::LAST_NAME => $data[CustomerModel::LAST_NAME],
            ]
        );
    }
}
