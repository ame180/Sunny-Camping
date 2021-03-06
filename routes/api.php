<?php

use App\Http\Controllers\Admin\ClientController;
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

Route::prefix('/client')->group(function () {
    Route::put('/add', [ClientController::class, 'add']);
    Route::patch('/update/{id}', [ClientController::class, 'update']);
    Route::patch('/settle/{id}', [ClientController::class, 'settle']);
    Route::delete('/delete/{id}', [ClientController::class, 'delete']);
    Route::get('/paginated', [ClientController::class, 'paginatedJson']);
    Route::get('/find/{id}', [ClientController::class, 'findJson']);
});

Route::prefix('/category')->group(function () {
    Route::get('/all-by-service/{serviceId}', [CategoryController::class, 'allByService']);
});
