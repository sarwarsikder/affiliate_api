<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/free-promotion', [HomeController::class, 'free_promotion'])->name('free-promotion');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop-details/{shop_id}', [HomeController::class, 'shop_details'])->name('shop-details');
