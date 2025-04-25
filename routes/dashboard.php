<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Middleware\MarkNotificationAsRead;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'auth',
    'prefix' => '/dashboard',
    'as' => 'dashboard.'

], function () {

    Route::resources([
        'categories' => CategoriesController::class,
        'stores' => StoreController::class,
        'products' => ProductController::class,
        'admins' => AdminController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);

});
