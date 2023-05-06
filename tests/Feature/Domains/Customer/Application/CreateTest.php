<?php

namespace Tests\Feature\Domains\Customer\Application;

use App\Domains\Customer\Domain\CustomerAlreadyExists;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\ValueObject\BankAccountValueObject;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_create_customer_with_invalid_phone_number(): void
    {
        $response = $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH =>  fake()->date('Y-m-d'),
            CustomerModel::EMAIL => fake()->email(),
            CustomerModel::BANK_ACCOUNT_NUMBER =>  BankAccountValueObject::random(),
            CustomerModel::PHONE_NUMBER => "+54218184848",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_not_create_customer_when_already_added_by_firstName_lastName_dateOfBirth(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(CustomerAlreadyExists::class);

        CustomerModel::factory()->create([
            CustomerModel::FIRST_NAME => $name = fake()->firstName(),
            CustomerModel::LAST_NAME =>  $lastName = fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH => $dateOfBirth = fake()->date('Y-m-d'),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);

        $response = $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  $name,
            CustomerModel::LAST_NAME =>  $lastName,
            CustomerModel::DATE_OF_BIRTH => $dateOfBirth,
            CustomerModel::EMAIL => fake()->email(),
            CustomerModel::BANK_ACCOUNT_NUMBER =>  BankAccountValueObject::random(),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);
    }

    public function test_not_create_customer_when_entered_email_not_unique(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(EloquentException::class);

        CustomerModel::factory()->create([
            CustomerModel::EMAIL => $email = fake()->email(),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);

        $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH =>  fake()->date('Y-m-d'),
            CustomerModel::EMAIL => $email,
            CustomerModel::BANK_ACCOUNT_NUMBER =>  BankAccountValueObject::random(),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);
    }

    public function test_not_create_customer_when_an_invalid_bank_account_number_entered(): void
    {
        $response = $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH =>  fake()->date('Y-m-d'),
            CustomerModel::EMAIL => fake()->email(),
            CustomerModel::BANK_ACCOUNT_NUMBER => fake()->numberBetween(11,22),
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_customer_successful(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('customers.store'), $data = [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName(),
            CustomerModel::DATE_OF_BIRTH =>  fake()->date('Y-m-d'),
            CustomerModel::EMAIL => fake()->email(),
            CustomerModel::BANK_ACCOUNT_NUMBER =>  BankAccountValueObject::random(),
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
