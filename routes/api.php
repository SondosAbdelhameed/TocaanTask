<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PaymentOrderController;
use App\Http\Controllers\UserAddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile',[AuthController::class, 'profile']);
        Route::get('logout',[AuthController::class, 'logout']);

        Route::resource('addresses', UserAddressController::class);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('orders',OrderController ::class)->only(['index','store','show','destroy']);
    Route::get('cancel-order/{orderId}',[OrderController ::class,'cancelOrder']);
    Route::resource('order-products',OrderProductController ::class)->only(['store','update','destroy']);
    Route::get('payment-methods',[PaymentOrderController ::class, 'paymentMethods']);
    Route::post('pay-order',[PaymentOrderController ::class, 'payOrder']);
    Route::get('order-payment-transactions/{id}',[PaymentOrderController ::class, 'orderPaymentTransaction']);
});

