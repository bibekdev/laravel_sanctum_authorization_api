<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [StudentController::class, 'register']);
Route::post('login', [StudentController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [StudentController::class, 'profile']);
    Route::get('logout', [StudentController::class, 'logout']);

    Route::post('create-project', [ProjectController::class, 'create']);
    Route::get('list-project', [ProjectController::class, 'listProject']);
    Route::get('list-project/{id}', [ProjectController::class, 'single']);
    Route::delete('delete-project/{id}', [ProjectController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
