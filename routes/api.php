<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AllProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\OrderDetailsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    //... controllers..//

   


//     $api = app('Laravel\App\Routing\Router');



Route::group(['v1'], function() {
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('products/categories/{id}', [CategoryController::class, 'show']);
        Route::get('search-categories/{search}', [CategoryController::class, 'searchUser']);
        Route::get('categories/{categoryId}/products', [ProductController::class, 'index']);
        Route::get('categories/{categoryId}/products/{id}', [ProductController::class, 'show']);
        Route::get('products', [ProductController::class, 'getProductByCategory']);
        Route::get('companies', [CompanyController::class, 'index']);
        Route::get('companies/{id}', [CompanyController::class, 'show']);
        Route::get('search-companies/{search}', [CompanyController::class, 'search']);
      
   

    Route::group(['prefix'=> 'auth'], function() {
           Route::post('register', [RegisterController::class, 'register']);
           Route::post('login', [LoginController::class, 'login']);
           Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
     Route::group(['middleware' => 'api:auth'], function() {
           Route::post('logout', [LogoutController::class, 'logout']);
           Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
           Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

        });
    });

    Route::group(['middleware' => 'me', 'middleware' => 'auth:sanctum'], function() {
       //....update profile....// 

       Route::get('carts', [CartController::class, 'index']);
       Route::post('carts', [CartController::class, 'store']);
       Route::post('/increments', [CartController::class, 'increment'])->name('increment');
       Route::post('/decrements', [CartController::class, 'decrement'])->name('decrement');
       Route::post('removecart', [CartController::class, 'removeCart'])->name('removeCart');
       Route::get('/cartitems', [CartController::class, 'getCartForOrderDetail']);
       Route::post('orders', [OrderController::class, 'store']);
       Route::get('orders/{order}', [OrderController::class, 'show']);
  

    });


    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::DELETE('users/{user}', [UserController::class, 'destroy']);
        Route::get('search-users/{search}', [UserController::class, 'searchUser']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('products/categories/{id}', [CategoryController::class, 'update']);
        Route::DELETE('categories/{id}', [CategoryController::class, 'destroy']);
       
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::DELETE('products/{id}', [ProductController::class, 'destroy']);
        Route::get('search-products/{search}', [ProductController::class, 'search']);
        Route::post('companies', [CompanyController::class, 'store']);
        Route::put('companies/{company}', [CompanyController::class, 'update']);
        Route::DELETE('companies/{company}', [CompanyController::class, 'destroy']);
        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::post('suppliers', [SupplierController::class, 'store']);
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show']);
        Route::put('suppliers/{supplier}', [SupplierController::class, 'update']);
        Route::DELETE('suppliers/{supplier}', [SupplierController::class, 'destroy']);
        Route::get('search-suppliers/{search}', [SupplierController::class, 'search']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::put('orders/{order}', [OrderController::class, 'update']);
        Route::DELETE('orders/{order}', [OrderController::class, 'destroy']);
        Route::get('search-orders/{search}', [OrderController::class, 'search']);
        Route::get('settings/{setting}', [SettingController::class, 'show']);
        Route::put('settings/{setting}', [SettingController::class, 'update']);
    
     });

  });
   
        
        Route::get('count-users', [HomeController::class, 'countUser']);
        Route::get('count-products', [HomeController::class, 'countProduct']);
        Route::get('count-companys', [HomeController::class, 'countCompany']);
        Route::get('count-categorys', [HomeController::class, 'countCategory']);


     // Route::resource('/users', [UserController::class]);
    // Route::resource('/orders', [OrderController::class]);
    // Route::resource('/products', [ProductController::class]);
    // Route::resource('/supplies', [SupplierController::class]);
   // Route::resource('/companies', [CompanyController::class]);
   // Route::resource('/transaction', [TransactionController::class]);
