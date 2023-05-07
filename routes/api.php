<?php

use App\Http\Controllers\Customer\CreateCustomerAction;
use App\Http\Controllers\Customer\DeleteCustomerAction;
use App\Http\Controllers\Customer\GetCustomerAction;
use App\Http\Controllers\Customer\SearchCustomersAction;
use App\Http\Controllers\Customer\UpdateCustomerAction;

Route::middleware(['api'])->prefix('v1')->group(function() {
    Route::group(['as' => 'customers.', 'name' => 'customers', 'prefix' => 'customers'], function() {
        Route::get('/', SearchCustomersAction::class)->name('index');
        Route::post('/', CreateCustomerAction::class)->name('store');
        Route::get('/{id}', GetCustomerAction::class)->name('show');
        Route::patch('/{id}', UpdateCustomerAction::class)->name('update');
        Route::delete('/{id}', DeleteCustomerAction::class)->name('destroy');
    });
});
