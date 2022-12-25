<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookManagementController;
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

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/user', [UserController::class, 'index']);
  Route::controller(BookController::class)->group(function () {
    Route::get('/v1/book', 'index');
    Route::get('/v1/book/{bookId}', 'show');
  });
  Route::put('/v1/book-management/{bookId}', [BookManagementController::class, 'update']);
});
