<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->where('year', '[0-9]+')->name('home');

Route::view('/old', 'home_old');

Route::prefix('/admin')->group(function () {
    Route::prefix('/clients')->group(function () {
        Route::get('/add-client', [ClientController::class, 'addClient']);
        Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('admin.clients.edit');
    });
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients');
    Route::get('/bills', [AdminController::class, 'bills']);
    Route::redirect('/', 'admin/dashboard');
});
