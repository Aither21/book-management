<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookManagementController;
use App\Http\Controllers\Api\ResetEmailController;
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

Route::post('/reset-email', [ResetEmailController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
  Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index');
    Route::get('/v1/users', 'list');
    Route::patch('/v1/user/{userId}', 'update');
  });
  Route::controller(BookController::class)->group(function () {
    Route::get('/v1/book', 'index');
    Route::get('/v1/book/{bookId}', 'show');
    Route::post('/v1/book', 'store');
  });
  Route::controller(BookManagementController::class)->group(function () {
    Route::put('/v1/book-management/{bookId}', 'update');
    Route::patch('/v1/book-management/{bookId}', 'adminUpdate');
    Route::get('/v1/book-management', 'index');
  });
});
