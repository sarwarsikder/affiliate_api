<?php

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ShopController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    /*Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{products}', [ProductController::class, 'update']);
    Route::delete('products/{products}', [ProductController::class, 'delete']);*/


    Route::get('shops', [ShopController::class, 'index']);
    Route::get('shops/{id}', [ShopController::class, 'show']);
    Route::post('shops-follow-unfollow', [ShopController::class, 'shop_follow_unfollow']);


});



