<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SocialMediaLinkController;
use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\OrderApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [CheckoutApiController::class, 'process']);
    Route::get('/checkout/payment-status', [CheckoutApiController::class, 'checkPaymentStatus']);
    Route::get('/orders', [OrderApiController::class, 'index']);
});

Route::prefix('customer')->group(function () {
    Route::post('register', [CustomerAuthController::class, 'register']);
    Route::post('login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [CustomerAuthController::class, 'profile']);
        Route::post('logout', [CustomerAuthController::class, 'logout']);
    });
});

Route::get('/banners', [BannerController::class, 'index']);
Route::apiResource('brands', BrandController::class);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/social-media-links', [SocialMediaLinkController::class, 'index']);
