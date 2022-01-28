<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;


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
Route::get('/', [AuthenticateController::class, 'welcome']);
Route::get('/success', [AuthenticateController::class, 'success']);
Route::get('/password/reset/{token}', [AuthenticateController::class, 'reset_form']);
Route::post('/updatePass', [AuthenticateController::class, 'resetPassword']);
Route::get('/image', [AuthenticateController::class, 'image']);
