<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('/admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);

    //Brands
    Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
    Route::post('/brands/store', [BrandsController::class, 'store'])->name('admin.brands.store');
    Route::patch('/brands/update/{id}', [BrandsController::class, 'update'])->name('admin.brands.update');
    Route::delete('/brands/delete/{id}', [BrandsController::class, 'delete'])->name('admin.brands.delete');
});

require __DIR__.'/auth.php';
