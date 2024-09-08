<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RequestIngredientController;
use App\Http\Controllers\RequestProductController;
use App\Http\Controllers\TransactionLogsController;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => ['redirect_to_admin', 'check.verified']], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop-detail/{id}', [ShopDetailController::class, 'index'])->name('shop-detail');
    Route::post('/product/detail', [HomeController::class, 'detail'])->name('product.detail');

    Route::get('/success', [CheckoutController::class, 'success'])->name('success');
});

// Route::get('/home', function () {
//     return view('pages.home');
// })->middleware(['auth', 'verified'])->name('home');

Route::group(['middleware' => ['auth', 'redirect_to_admin', 'verified']], function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/cost', [CheckoutController::class, 'cost'])->name('cost');
    Route::post('/shippingfee', [CheckoutController::class, 'shippingfee'])->name('shippingfee');

    Route::post('/getkota', [AddressController::class, 'getkota'])->name('getkota');
    Route::post('/getkecamatan', [AddressController::class, 'getkecamatan'])->name('getkecamatan');
    Route::post('/getdesa', [AddressController::class, 'getdesa'])->name('getdesa');
    Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
    Route::post('/calculate-distance', [DeliveryController::class, 'calculateDistance']);

    Route::post('/add-to-cart/{id}', [ShopDetailController::class, 'add'])->name('add-to-cart');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');

    Route::post('/cart/add-quantity', [CartController::class, 'addQuantity'])->name('cart.add-quantity');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/order-list', [OrderListController::class, 'index'])->name('order');
    Route::get('/order-list-detail/{transactions_id}', [OrderListController::class, 'show'])->name('order.detail');
    Route::post('/order-list-detail/{transactions_id}', [OrderListController::class, 'update'])->name('order.update');

    // Route::post('/review/store', [CustomerReviewController::class, 'store'])->name('review.store');
    // Route::post('/review/update/{id}', [CustomerReviewController::class, 'update'])->name('review.update');

    Route::get('/address', [AddressController::class, 'index'])->name('address');
    Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // hero
    Route::get('/herosection', [HeroSectionController::class, 'index'])->name('herosection');
    Route::get('/herosection/create', [HeroSectionController::class, 'create'])->name('herosection.create');
    Route::post('/herosection/store', [HeroSectionController::class, 'store'])->name('herosection.store');
    Route::get('/herosection/{id}', [HeroSectionController::class, 'edit'])->name('herosection.edit');
    Route::post('/herosection/update/{id}', [HeroSectionController::class, 'update'])->name('herosection.update');
    Route::delete('/herosection/{id}', [HeroSectionController::class, 'destroy'])->name('herosection.destroy');

    // about
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/about/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('/about/store', [AboutController::class, 'store'])->name('about.store');
    Route::get('/about/{id}', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update/{id}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/{id}', [AboutController::class, 'destroy'])->name('about.destroy');

    // menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // product transaction logs
    Route::get('/product-transactions', [ProductController::class, 'productTransactions'])->name('product.productTransactions');
    // web.php
    Route::get('/product-transaction/download-pdf', [ProductController::class, 'downloadPdf'])->name('product.downloadPdf');

    // transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::post('/transaction/{id}/process-refund', [TransactionController::class, 'processRefund'])->name('transaction.processRefund');
    Route::post('/transaction/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');

    // Transaction Logs
    Route::get('/transaction-logs', [TransactionLogsController::class, 'transactionLogs'])->name('transactionLogs.index');
    Route::get('/transaction-logs/download-pdf', [TransactionLogsController::class, 'downloadPdf'])->name('transactionLogs.downloadPdf');


    // TEMPORARY: Cek Resi Route
    Route::get('/cek-resi', [TransactionController::class, 'cekResi'])->name('cekResi');
    Route::post('/cek-resi', [TransactionController::class, 'cekResiProcess'])->name('cekResiProcess');

    // reviews
    // Route::get('/reviews', [CustomerReviewController::class, 'index'])->name('reviews.index');
    // Route::get('/reviews/{id}', [CustomerReviewController::class, 'edit'])->name('reviews.edit');

    // bahan baku
    Route::get('/ingredient', [IngredientController::class, 'index'])->name('ingredient.index');
    Route::post('/ingredient/store', [IngredientController::class, 'store'])->name('ingredient.store');
    Route::put('/ingredient/{id}', [IngredientController::class, 'update'])->name('ingredient.update');
    Route::delete('/ingredient/{id}', [IngredientController::class, 'destroy'])->name('ingredient.destroy');


    // request bahan baku
    Route::get('/request-bahan-baku', [RequestIngredientController::class, 'index'])->name('requestIngredient.index');
    Route::post('/request-bahan-baku/store', [RequestIngredientController::class, 'store'])->name('requestIngredient.store');
    Route::post('/request-bahan-baku/status-edit', [RequestIngredientController::class, 'statusEdit'])->name('requestIngredient.statusEdit');
    Route::get('/request-bahan-baku/{id}', [RequestIngredientController::class, 'show'])->name('requestIngredient.show');

    Route::get('/request-bahan-baku/logs', [RequestIngredientController::class, 'logs'])->name('requestIngredient.logs');

    // request product
    Route::get('/request-product', [RequestProductController::class, 'index'])->name('requestProduct.index');
    Route::post('/request-product/store', [RequestProductController::class, 'store'])->name('requestProduct.store');
    Route::post('/request-product/status-edit', [RequestProductController::class, 'statusEdit'])->name('requestProduct.statusEdit');
    Route::get('/request-product/{id}', [RequestProductController::class, 'show'])->name('requestProduct.show');

    // Inbox
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/create', [InboxController::class, 'create'])->name('inbox.create');
    Route::post('/inbox', [InboxController::class, 'store'])->name('inbox.store');
    Route::get('/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');
});

Route::post('/midtrans-callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');

require __DIR__ . '/auth.php';
