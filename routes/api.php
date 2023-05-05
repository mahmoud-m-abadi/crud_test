<?php

use App\Http\Controllers\Customer\CreateCustomerController;

Route::middleware(['api'])->prefix('api/v1')->group(function() {
    Route::prefix('customers')->group(function() {
        Route::post('/', CreateCustomerController::class)->name('customers.store');
//        Route::get('/{id}', GetBoardByIdController::class);
//        Route::patch('/{id}', UpdateBoardController::class);
//        Route::delete('/{id}', DeleteBoardController::class);
//        Route::get('/', SearchBoardsController::class);
    });
});
