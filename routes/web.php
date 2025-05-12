<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');


    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

    Route::get('/materials/{id}/details', [MaterialController::class, 'getMaterialDetails'])->name('materials.details');


    Route::get('/workers', [WorkerController::class, 'index'])->name('workers.index');
    Route::post('/workers', [WorkerController::class, 'store'])->name('workers.store');
    Route::put('/workers/{worker}', [WorkerController::class, 'update'])->name('workers.update');
    Route::delete('/workers/{worker}', [WorkerController::class, 'destroy'])->name('workers.destroy');

    // web.php (routes)
    Route::get('/workers/{id}/details', [WorkerController::class, 'getWorkerDetails']);



    Route::get('/billings', [BillingController::class, 'index'])->name('billings.index');
    Route::post('/billings', [BillingController::class, 'store'])->name('billings.store');


    Route::delete('/billings/{billing}', [BillingController::class, 'destroy'])->name('billings.destroy');

    // Route for print
    Route::get('billings/{billing}/print', [BillingController::class, 'print'])->name('billings.print');



});
