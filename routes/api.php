<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Testing;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// --- Public Routes ---
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// --- Protected Routes (Wrapped with Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout route
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Project route start here
    Route::apiresource('departments', App\Http\Controllers\DepartmentController::class);
    Route::apiresource('employees', App\Http\Controllers\EmployeeController::class);
});