<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Buyer;
use App\Http\Controllers\AuthUser;
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

Route::get('/login', [AuthUser::class, 'LoginPage'])->name('page.login');
Route::post('/login', [AuthUser::class, 'Login'])->name('login.process');
Route::get('/register', [AuthUser::class, 'RegisterPage'])->name('page.register');
Route::post('/register', [AuthUser::class, 'Register'])->name('register.process');
Route::get('/', [Buyer::class, 'User'])->name('buyer');
Route::group(['middleware' => 'auth.default'], function () {
    Route::get('/order', [Buyer::class, 'UserOrder'])->name('order')->middleware('role:buyer');
    Route::get('/admin', [Admin::class, 'Admin'])->name('admin')->middleware('role:admin,cslayer1,cslayer2');
    Route::get('/cslayer1', [Admin::class, 'csLayer1'])->name('products.cslayer1')->middleware('role:admin,cslayer1');
    Route::get('/cslayer2', [Admin::class, 'csLayer2'])->name('products.cslayer2')->middleware('role:admin,cslayer2');
    Route::get('/product-control', [Admin::class, 'ProductControl'])->name('products.control')->middleware('role:admin');
    Route::get('/logout', [AuthUser::class, 'Logout'])->name('logout');
});
