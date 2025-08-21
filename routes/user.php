<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Core\HomeController;

Route::middleware(['auth.user'])->group(function () {

     Route::prefix('expenses')
               ->name('expenses.')
               ->group(function () {

          Route::resource('/', ExpenseController::class)->only(['index', 'store']);
          Route::get('grouped', [ExpenseController::class, 'grouped'])->name('grouped');
     });

     Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
     Route::get('/dashboard/chart-data', [HomeController::class, 'chartData'])->name('dashboard.chart-data');
     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
