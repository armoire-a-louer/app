<?php

use App\Http\Controllers\AddressController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\ColorsController;
use App\Http\Controllers\Admin\ModelsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\MaterialsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductsController as ProductsControllerFront;
use App\Http\Controllers\ReservationsController;

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

// BACK-OFFICE
Route::middleware(['auth', 'admin'])->prefix('/admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Brands
    Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
    Route::post('/brands/store', [BrandsController::class, 'store'])->name('admin.brands.store');
    Route::post('/brands/update/{id}', [BrandsController::class, 'update'])->name('admin.brands.update');
    Route::delete('/brands/delete/{id}', [BrandsController::class, 'delete'])->name('admin.brands.delete');

    // Products
    Route::get('/products', [ProductsController::class, 'index'])->name('admin.products.index');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::post('/products/update/{product}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/destroy/{product}', [ProductsController::class, 'destroy'])->name('admin.products.delete');

    // Items (products)
    Route::delete('/products/delete-item/{item}', [ProductsController::class, 'deleteItem'])->name('admin.products.items.delete');
    Route::post('/products/store-item', [ProductsController::class, 'storeItem'])->name('admin.products.items.store');
    Route::post('/products/update_item/{item}', [ProductsController::class, 'updateItem'])->name('admin.products.items.update');

    // Categories
    Route::get('/categories', [CategoriesController:: class, 'index'])->name('admin.categories.index');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/destroy/{category}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    Route::post('/categories/update/{category}', [CategoriesController::class, 'update'])->name('admin.categories.update');

    // Colors
    Route::get('/colors', [ColorsController::class, 'index'])->name('admin.colors.index');
    Route::post('/colors/store', [ColorsController::class, 'store'])->name('admin.colors.store');
    Route::delete('/colors/delete/{color}', [ColorsController::class, 'delete'])->name('admin.colors.delete');
    Route::put('/colors/update/{color}', [ColorsController::class, 'update'])->name('admin.colors.update');

    // Materials
    Route::get('/materials', [MaterialsController::class, 'index'])->name('admin.materials.index');
    Route::post('/materials/store', [MaterialsController::class, 'store'])->name('admin.materials.store');
    Route::put('/materials/update/{material}', [MaterialsController::class, 'update'])->name('admin.materials.update');
    Route::delete('/materials/delete/{material}', [MaterialsController::class, 'delete'])->name('admin.materials.delete');

    // Models
    Route::get('/models', [ModelsController::class, 'index'])->name('admin.models.index');
    Route::post('/models/store', [ModelsController::class, 'store'])->name('admin.models.store');
    Route::post('/models/update/{model}', [ModelsController::class, 'update'])->name('admin.models.update');
    Route::delete('/models/delete/{model}', [ModelsController::class, 'delete'])->name('admin.models.delete');

    // Transactions
    Route::get('/transactions', [TransactionsController::class, 'index'])->name('admin.transactions.index');
    Route::get('/transaction/{transaction}', [TransactionsController::class, 'show'])->name('admin.transactions.show');

    // Users
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/user/{user}', [UsersController::class, 'show'])->name('admin.users.show');
    Route::put('/user/update/{user}', [UsersController::class, 'update'])->name('admin.users.update');
});

// FRONT
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/notre-concept', [HomeController::class, 'concept'])->name('concept'); 
Route::get('/product/{product}', [ProductsControllerFront::class, 'view'])->name('product');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->middleware("auth")->name('checkout');
Route::post('/add-to-basket', [ReservationsController::class, 'addToBasket'])->middleware("auth")->name('add-to-basket');
Route::delete('/remove-from-basket/{reservationCommonUuid}', [ReservationsController::class, 'deleteReservation'])->middleware("auth")->name('remove-from-basket');
Route::post('/pay', [CheckoutController::class, 'pay'])->middleware('auth')->name('pay');

// Route pour savoir si un utilisateur a liké un produit
Route::get('/is-product-liked/{productId}', [ProductsControllerFront::class, 'isProductLiked'])->middleware('auth')->name('is-product-liked');
Route::post('/like-or-dislike/{productId}', [ProductsControllerFront::class, 'likeOrDislike'])->name('like-or-dislike');


// STRIPE
Route::post('/webhook', [CheckoutController::class, 'webhook'])->name('webhook');

// Account
Route::get('/dashboard', [DashboardController::class, 'reservations'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/add-address', [AddressController::class, 'addAddress'])->name('add-address');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'delete'])->name('addresses.delete');

    Route::get('/likes', [DashboardController::class, 'likes'])->name('likes.index');
});



require __DIR__.'/auth.php';
