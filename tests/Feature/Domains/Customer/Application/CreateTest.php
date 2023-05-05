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
        $response = $this->getJson(route('customers.store'), [
            CustomerModel::FIRST_NAME =>  fake()->firstName(),
            CustomerModel::LAST_NAME =>  fake()->lastName()
        ]);

        $response->assertStatus(200);
    }
}
