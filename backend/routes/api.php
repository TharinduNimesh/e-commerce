<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
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
Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'Logged out successfully',
    ]);
})->middleware('auth:sanctum');

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
Route::prefix('publishers')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [PublisherController::class, 'index']);
    Route::get('/{id}', [PublisherController::class, 'show']);
    Route::post('/create', [PublisherController::class, 'create']);
});

// Comic Routes
Route::prefix('comics')->group(function () {
    Route::get('/', [ComicController::class, 'index']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/bought', [ComicController::class, 'getBoughtComics']);
        Route::put('/{id}', [ComicController::class, 'update']);
        Route::delete('/{id}', [ComicController::class, 'remove']);
        Route::put('/hide/{id}', [ComicController::class, 'toggleHide']);
        Route::post('/create', [ComicController::class, 'create']);
    });
    Route::get('/{id}', [ComicController::class, 'show']);
});

Route::prefix('cart')->group(function () {
    Route::post('/', [CartController::class, 'index']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/add', [CartController::class, 'create']);
        Route::delete('/', [CartController::class, 'remove']);
    });
});

// Payment Routes
Route::prefix('payments')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/add', [PaymentController::class, 'create']);
    Route::put('/update/{id}', [PaymentController::class, 'update']);
    Route::delete('/delete/{id}', [PaymentController::class, 'delete']);
});

Route::prefix('support')->group(function () {
    ROute::post('/send-message', [MessageController::class, 'create'])->middleware('throttle:api');
});

Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::put('/update', [UserController::class, 'update']);
});

Route::post('/checkout', [PaymentController::class, 'checkout'])->middleware('auth:sanctum');
Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
