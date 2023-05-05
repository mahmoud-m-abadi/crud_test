<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Customer\Infrastructure\CustomerModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CustomerModel::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CustomerModel::FIRST_NAME, 50);
            $table->string(CustomerModel::LAST_NAME, 50);
            $table->string(CustomerModel::EMAIL, 60)->unique();
            $table->date(CustomerModel::DATE_OF_BIRTH);

            $table->unsignedBigInteger(CustomerModel::PHONE_NUMBER)->index(); // Maybe need to search with just this column
            $table->unsignedBigInteger(CustomerModel::BANK_ACCOUNT_NUMBER);

            $table->unique([CustomerModel::FIRST_NAME, CustomerModel::LAST_NAME, CustomerModel::DATE_OF_BIRTH]);
            $table->index([CustomerModel::FIRST_NAME, CustomerModel::LAST_NAME]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CustomerModel::TABLE);
    }
};
