<?php
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
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

//Authenticaed routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'get');
    });

    Route::controller(ReviewController::class)->group(function () {
        Route::post('/product/rating', 'create');
    });
});


//product routes
Route::controller(ProductController::class)->group(function () {
    Route::get('/products',  'get');
    Route::post('/product/create', 'create');
});

//unauthenticaed routes
Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
Route::post('/register', [AuthController::class, 'createUser']);
