<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PlaceOrderController;
use App\Http\Controllers\ReviewsController;

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

Route::get('/GetSpecificUser/{id}', [AuthenticateController::class, 'getUser']);
Route::post('/signup',[AuthenticateController::class, 'store']);
Route::post('/login', [AuthenticateController::class, 'login']);
Route::post('/forget-password', [AuthenticateController::class, 'checkemail']);

Route::post('/updateProfile/{id}', [AuthenticateController::class, 'updateProfile']);

Route::post('/AddProduct', [ProductController::class, 'AddProduct']);
Route::post('/UpdateProduct/{id}', [ProductController::class, 'UpdateProduct']);
Route::get('/DeleteProduct/{id}', [ProductController::class, 'destroy']);
Route::post('/addcount/{id}', [ProductController::class, 'saveUserPayment']);

Route::post('/AddMarket', [MarketController::class, 'AddMarket']);
Route::post('/UpdateMarket/{id}', [MarketController::class, 'UpdateMarket']);
Route::get('/DeleteMarket/{id}', [MarketController::class, 'destroy']);

Route::post('/PlaceOrder', [PlaceOrderController::class, 'PlaceOrder']);
Route::post('/UpdatePlaceOrder/{id}', [PlaceOrderController::class, 'UpdatePlaceOrder']);
Route::get('/DeletePlaceOrder/{id}', [PlaceOrderController::class, 'DeletePlaceOrder']);

Route::get('/GetAllOrders', [PlaceOrderController::class, 'GetAllOrders']);
Route::get('/GetAllOrdersProducts/{ids}', [PlaceOrderController::class, 'Prodcts']);
Route::get('/GetSpecificOrder/{userid}', [PlaceOrderController::class, 'viewid']);
Route::get('/GetOrder/{id}', [PlaceOrderController::class, 'view']);

Route::get('/GetSpecificProduct/{id}', [ProductController::class, 'viewid']);
Route::get('/GetSpecificMarket/{id}', [MarketController::class, 'viewid']);

Route::get('/GetAllProduct', [ProductController::class, 'view1']);
Route::get('/GetAllMarket', [MarketController::class, 'view1']);

Route::get('/GetProductByUserId/{userid}', [ProductController::class, 'view']);
Route::get('/GetMarketByUserId/{userid}', [MarketController::class, 'view']);

Route::post('/SearchMarketByName', [MarketController::class, 'search']);
Route::post('/SearchProductByName', [ProductController::class, 'search']);

Route::get('/ProductImage', [AuthenticateController::class, 'Productimage']);

Route::get('/MostVisitedProducts', [ProductController::class, 'visited']);

Route::post('/AddCategory', [CategoryController::class, 'AddCategory']);
Route::post('/UpdateCategory/{id}', [CategoryController::class, 'UpdateCategory']);
Route::get('/DeleteCategory/{id}', [CategoryController::class, 'destroy']);

Route::get('/GetSpecificCategory/{id}', [CategoryController::class, 'viewid']);
Route::get('/GetAllCategory', [CategoryController::class, 'view1']);
Route::get('/GetCategoryProduct/{productid}', [CategoryController::class, 'product']);
Route::get('/GetCategoryMarket/{marketid}', [CategoryController::class, 'market']);

Route::post('/AddReviews', [ReviewsController::class, 'reviews']);
Route::get('/GetReviews/{id}', [ReviewsController::class, 'GetReviews']);
Route::get('/GetAllReviews', [ReviewsController::class, 'AllReviews']);
Route::get('/GetReviewsByUserId/{user_id}', [ReviewsController::class, 'UserID']);
