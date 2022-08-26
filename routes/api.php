<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/supplier', SupplierController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/product', ProductController::class);
Route::apiResource('/expense', ExpenseController::class);
Route::apiResource('/customer', CustomerController::class);

Route::post('/salary/paid/{id}', [SalaryController::class, 'paid']);
Route::get('/salary', [SalaryController::class, 'allSalary']);

Route::get('/salary/view/{id}', [SalaryController::class, 'viewSalary']);
Route::get('/salary/edit/{id}', [SalaryController::class, 'editSalary']);
Route::post('/salary/update/{id}', [SalaryController::class, 'updateSalary']);

Route::post('stock/update/{id}', [ProductController::class, 'stockUpdate']);

Route::get('/getting/product/{id}', [PosController::class, 'getProduct']);

//add to cart 
Route::get('/addToCart/{id}', [CartController::class, 'addToCart']);

//fetch all inside cart
Route::get('/cart/product/', [CartController::class, 'cartProduct']);

//delete cart
Route::get('/remove/cart/{id}', [CartController::class, 'removeCart']);

//increment and decrement
Route::get('/cart/increment/{id}', [CartController::class, 'increment']);
Route::get('/cart/decrement/{id}', [CartController::class, 'decrement']);

//Vat routre
Route::get('/vats', [CartController::class, 'vats']);

//Order done 
Route::post('/orderDone', [PosController::class, 'orderDone']);

//Orderapi route
Route::get('/orders', [OrderController::class, 'todayOrder']);

Route::get('/orders/details/{id}', [OrderController::class, 'orderDetails']);
Route::get('/orders/orderdetails/{id}', [OrderController::class, 'orderDetailsAll']);



