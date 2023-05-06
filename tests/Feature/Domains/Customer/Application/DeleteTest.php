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
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_not_delete_when_not_found(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(CustomerNotFound::class);

        $customer = CustomerModel::factory()->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $this->deleteJson(route('customers.destroy', 555));
    }

    public function test_customer_is_deleted_successfully(): void
    {
        $this->withoutExceptionHandling();

        $customer = CustomerModel::factory()->create([
            CustomerModel::PHONE_NUMBER => $this->phoneNumber
        ]);

        $this->deleteJson(route('customers.destroy', $customer->id));

        $this->assertDatabaseMissing(
            CustomerModel::TABLE, [CustomerModel::ID => $customer->id]
        );
    }
}
