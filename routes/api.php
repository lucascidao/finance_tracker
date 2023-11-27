<?php

use App\Http\Controllers\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});

    Route::prefix('transaction')->group(function () {
        Route::get('/indexIncome', [TransactionsController::class, 'indexIncome']);
        Route::get('/indexExpense', [TransactionsController::class, 'indexExpense']);
        Route::post('/store', [TransactionsController::class, 'store']);
        Route::post('/update/{id}', [TransactionsController::class, 'update']);
        Route::delete('/{id}', [TransactionsController::class, 'delete']);
        Route::get('/expenseData', [TransactionsController::class, 'expenseData']);
        Route::get('/transactionByMonth', [TransactionsController::class, 'transactionByMonth']);

        // Route::get('/show/{id}', [TransactionsController::class, 'show']);
});


