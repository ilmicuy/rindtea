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
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop-detail/{id}', [ShopDetailController::class, 'index'])->name('shop-detail');


Route::get('/success', [CheckoutController::class, 'success'])->name('success');

// Route::get('/home', function () {
//     return view('pages.home');
// })->middleware(['auth', 'verified'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::post('/add-to-cart/{id}', [ShopDetailController::class, 'add'])->name('add-to-cart');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/order-list', [OrderListController::class, 'index'])->name('order');
    Route::get('/order-list-detail/{transactions_id}', [OrderListController::class, 'show'])->name('order.detail');
    
    Route::post('/review/store', [CustomerReviewController::class, 'store'])->name('review.store');
    Route::post('/review/update/{id}', [CustomerReviewController::class, 'update'])->name('review.update');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::post('/transaction/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');

    Route::get('/reviews', [CustomerReviewController::class, 'index'])->name('reviews');
    Route::get('/reviews/{id}', [CustomerReviewController::class, 'edit'])->name('reviews.edit');
});

require __DIR__ . '/auth.php';
