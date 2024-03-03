<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use \App\Http\Controllers\Dashboard\ClientController;
use \App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\OrderController as OrderControllerAlias;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){



            Route::get('/index', [DashboardController::class , 'index'])->name('index');


            // user route
            Route::resource('users', UserController::class)->except(['show']);

            // categories route
            Route::resource('categories' , CategoriesController::class)->except(['show']);

            // products route
            Route::resource('products' , ProductController::class)->except(['show']);

            // clients route
            Route::resource('clients' , ClientController::class)->except(['show']);
            Route::resource('clients.orders' , OrderController::class)->except('show');
            Route::get('clients/{client}/orders/{order}' , [OrderController::class , 'details'])->name('clients.orders.details');

            //orders route
            Route::resource('orders' , OrderControllerAlias::class);
            Route::get('/orders/{order}/products', [OrderControllerAlias::class  ,'products'])->name('orders.products');
            Route::put('/orders/{order}/products', [OrderControllerAlias::class  ,'updateStatus'])->name('orders.update_status');
        });
});

