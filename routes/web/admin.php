<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\NotificationController;

Route::prefix('admin')->group(function(){

    Route::get('login' , [AuthController::class , 'login'])->name('admin.login');
    Route::post('login' , [AuthController::class , 'record']);
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard' , [DashboardController::class , 'dashboard']);
        Route::get('logout' , [AuthController::class , 'logout']);
        Route::post('update-profile' , [AuthController::class , 'updateProfile']);

        Route::controller(OrderController::class)->group(function(){
            Route::get('orders' , 'index');
        });
        Route::controller(NotificationController::class)->group(function(){
            Route::get('notifications' , 'index');
        });

    });
});