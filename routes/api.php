<?php

use App\Http\Controllers\Customer\CreateCustomerAction;
use App\Http\Controllers\Customer\DeleteCustomerAction;

Route::middleware(['api'])->prefix('api/v1')->group(function() {
    Route::prefix('customers')->group(function() {
        Route::post('/', CreateCustomerAction::class)->name('customers.store');
//        Route::get('/{id}', GetBoardByIdController::class);
//        Route::patch('/{id}', UpdateBoardController::class);
        Route::delete('/{customerId}', DeleteCustomerAction::class)->name('customers.destroy');
//        Route::get('/', SearchBoardsController::class);
    });
});
