<?php

use App\Api\StooqApi;
use App\Helpers\StockRequestHelper;
use App\Notifications\StockRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
Route::apiResource('users', App\Http\Controllers\UserController::class);
Route::get('user/history', [App\Http\Controllers\UserController::class, 'history'])->middleware('auth:sanctum');
Route::get('stock', [App\Http\Controllers\StockController::class, 'index'])->middleware('auth:sanctum');
Route::get('/notification', function () {
    return (new StockRequested((new StockRequestHelper(StooqApi::getStock('aapl.us')))->getStockData()))
        ->toMail(
            User::find(1)
        );
});