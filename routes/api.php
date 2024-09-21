<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/teams', [TeamController::class, 'create']);
    Route::get('/teams', [TeamController::class, 'getUserTeams']);
    Route::post('/teams/{teamId}/users', [TeamController::class, 'addUserToTeam']);
    Route::delete('/teams/{teamId}/users/{userId}', [TeamController::class, 'deleteUserFromTeam']);
});
