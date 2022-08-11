<?php

use App\Http\Controllers\Backend\Category\Controllers\CategoryController;
use App\Http\Controllers\Backend\Discount\Controllers\DiscountController;
use App\Http\Controllers\Backend\DiscountRule\Controllers\DiscountRuleController;
use App\Http\Controllers\Backend\Order\Controllers\OrderController;
use App\Http\Controllers\Backend\Product\Controllers\ProductController;
use App\Http\Controllers\Backend\User\Controllers\UserController;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('product', ProductController::class);
Route::apiResource('category', CategoryController::class);
Route::post('user/login', [UserController::class,'login']);
Route::post('user/register', [UserController::class,'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('order', OrderController::class);
    Route::get('discount/calculate', [DiscountController::class,'calculateDiscount']);
    Route::get('order_discounts/{order_id}', [DiscountController::class,'getOrderDiscounts']);
    Route::apiResource('discount_rule', DiscountRuleController::class);
});
