<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OrderAdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('\App\Http\Middleware\ValidateToken::class')->group(function () {
    Route::resource('categories', CategoryController::class)->names('api.categories');
    Route::resource('items', \App\Http\Controllers\Api\ItemsController::class)->names('api.items');
    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::delete('cart/item', [CartController::class, 'deleteItem']);
    Route::delete('cart/clear/all', [CartController::class, 'clearCart']);
    Route::get('cart', [CartController::class, 'getCart']);
    Route::get('cart/itemcount', [CartController::class, 'getItemCount']);
    Route::resource('order', \App\Http\Controllers\Api\OrderController::class)->names('api.order');
    Route::get('user/details', [UserController::class, 'getUserDetails']);
});


