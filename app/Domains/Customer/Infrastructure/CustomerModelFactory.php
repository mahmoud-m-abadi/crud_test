<?php

namespace App\Domains\Customer\Infrastructure;

use App\Domains\Shared\Domain\ValueObject\BankAccountValueObject;
use App\Domains\Shared\Domain\ValueObject\PhoneValueObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerModelFactory extends Factory
{
    protected $model = CustomerModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            CustomerModel::FIRST_NAME => fake()->name(),
            CustomerModel::LAST_NAME => fake()->lastName(),
            CustomerModel::EMAIL => fake()->unique()->safeEmail(),
            CustomerModel::DATE_OF_BIRTH => now()->subYears(20)->format('Y-m-d'),
            CustomerModel::PHONE_NUMBER => str_replace(['-','(',')',' ','/','\\'], '', fake()->phoneNumber),
            CustomerModel::BANK_ACCOUNT_NUMBER => BankAccountValueObject::random(),
        ];
    }
}
