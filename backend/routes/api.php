<?php

use App\Http\Controllers\Auth\AuthController;
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
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::put('/update-password', [AuthController::class, 'UpdatePassword']);
});


// global auth middleware
Route::middleware('auth:sanctum')->group(function() {
    Route::put('/change-password', [AuthController::class, 'changePassword']);
});

// temporary route for testing
Route::get('/deploy', [UserController::class, 'deploy']);
