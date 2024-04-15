<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop-detail', [ShopDetailController::class, 'index'])->name('shop-detail');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');


// Route::get('/home', function () {
//     return view('pages.home');
// })->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
