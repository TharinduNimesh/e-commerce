<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
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
    return response()->json([
        'status' => 'success',
        'user' => $request->user(),
    ]);
});

Route::post('/newsletter', [UserController::class, 'subscribe']);

// Auth routes
Route::middleware('throttle:auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
    Route::post('/verify', [PasswordController::class, 'verify']);
    Route::put('/update-password', [PasswordController::class, 'UpdatePassword']);
});

// Change password
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/change-password', [PasswordController::class, 'changePassword']);
});

// Publisher routes
Route::prefix('publisher')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [PublisherController::class, 'index']);
    Route::post('/create', [PublisherController::class, 'create']);
});

// Comic Routes
Route::prefix('comics')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [ComicController::class, 'index']);
    Route::post('/create', [ComicController::class, 'create']);
});

// temporary route for testing
Route::get('/deploy', [UserController::class, 'deploy']);
