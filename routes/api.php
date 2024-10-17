<?php

use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\CategoryController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/clients', [ClientController::class, 'getMultiple']);
    Route::get('/clients/export-registered', [ClientController::class, 'exportRegistered']);
    Route::get('/clients/{id}', [ClientController::class, 'get']);
    Route::post('/clients', [ClientController::class, 'add']);
    Route::post('/clients/{id}/settle', [ClientController::class, 'settle']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'delete']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/categories', [CategoryController::class, 'getMultiple']);
});
