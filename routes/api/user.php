<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\ProductController;


Route::prefix('v1')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        Route::post('register' , 'register');
        Route::post('login' ,'login');

        Route::middleware(['auth:user'])->group(function () {
            Route::get('logout' ,'logout');
        });
    });


    Route::controller(ProductController::class)->group(function(){
        Route::middleware(['auth:user'])->group(function () {
            Route::get('products' ,'products');
            Route::get('product/{id}' ,'product');
        });
    });

    Route::controller(CartController::class)->group(function(){
        Route::middleware(['auth:user'])->group(function () {
            Route::get('cart' ,'cart');
            Route::post('addToCart' ,'addToCart');
            Route::get('removeFromCart/{id}' ,'removeFromCart');
            Route::get('clearCart' ,'clearCart');
            Route::get('increaseCart/{id}' ,'increaseCart');
            Route::get('decreaseCart/{id}' ,'decreaseCart');
        });
    });


    Route::controller(OrderController::class)->group(function(){
        Route::middleware(['auth:user'])->group(function(){
            Route::post('order' , 'order');
            Route::get('orderDetails/{id}' , 'orderDetails');

            Route::get('orderDelivered/{id}' , 'orderDelivered');
            Route::get('orderNotDelivered/{id}' , 'orderNotDelivered');
        });
    });

});
