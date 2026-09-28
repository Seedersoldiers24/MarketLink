<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FarmerDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiChatController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

Route::get('/markets', [MarketController::class, 'index'])->name('markets.index');
Route::get('/market/{slug}', [MarketController::class, 'show'])->name('markets.show');

Route::get('/farmers', [FarmerController::class, 'index'])->name('farmers.index');
Route::get('/farmer/{id}', [FarmerController::class, 'show'])->name('farmers.show')->whereNumber('id');
Route::post('/farmer/{id}/review', [FarmerController::class, 'storeReview'])->name('farmers.review')->whereNumber('id');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{slug}/review', [ProductController::class, 'storeReview'])->name('products.review');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/api/ai-chat', [AiChatController::class, 'reply'])->name('ai.chat');


Route::middleware(['auth'])->group(function () {
   
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/order-confirmation/{order_number}', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/update-notes', [OrderController::class, 'updateNotes'])->name('orders.update_notes');
    Route::post('/orders/{id}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');


    Route::prefix('customer')->name('customer.')->middleware(['role:customer'])->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/favorites', [CustomerController::class, 'favorites'])->name('favorites');
        Route::post('/favorites/toggle', [CustomerController::class, 'toggleFavorite'])->name('favorites.toggle');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    });
});


Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [FarmerDashboardController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/status', [FarmerDashboardController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/products', [FarmerDashboardController::class, 'products'])->name('products');
    Route::post('/products', [FarmerDashboardController::class, 'storeProduct'])->name('products.store');
    Route::post('/products/{id}/update', [FarmerDashboardController::class, 'updateProduct'])->name('products.update');
    Route::post('/products/{id}/toggle-sold', [FarmerDashboardController::class, 'toggleSoldOut'])->name('products.toggle_sold');
    Route::post('/products/apply-template', [FarmerDashboardController::class, 'applyWeeklyTemplate'])->name('products.apply_template');
    Route::post('/products/{id}/delete', [FarmerDashboardController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/profile', [FarmerDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [FarmerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/reviews', [FarmerDashboardController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{id}/reply', [FarmerDashboardController::class, 'replyReview'])->name('reviews.reply');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/farmers', [AdminDashboardController::class, 'farmers'])->name('farmers');
    Route::post('/farmers/{id}/toggle-approval', [AdminDashboardController::class, 'toggleFarmerApproval'])->name('farmers.toggle');
    Route::get('/customers', [AdminDashboardController::class, 'customers'])->name('customers');
    Route::post('/customers/{id}/toggle-status', [AdminDashboardController::class, 'toggleCustomerStatus'])->name('customers.toggle');
    Route::get('/markets', [AdminDashboardController::class, 'markets'])->name('markets');
    Route::post('/markets', [AdminDashboardController::class, 'storeMarket'])->name('markets.store');
    Route::post('/markets/{id}/update', [AdminDashboardController::class, 'updateMarket'])->name('markets.update');
    Route::post('/markets/{id}/delete', [AdminDashboardController::class, 'destroyMarket'])->name('markets.destroy');
    Route::get('/moderation', [AdminDashboardController::class, 'moderation'])->name('moderation');
    Route::post('/moderation/reviews/{id}/delete', [AdminDashboardController::class, 'deleteReview'])->name('moderation.review.delete');
    Route::post('/moderation/products/{id}/delete', [AdminDashboardController::class, 'deleteProduct'])->name('moderation.product.delete');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::post('/reports/generate', [AdminDashboardController::class, 'generateReport'])->name('reports.generate');
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::get('/announcements', [AdminDashboardController::class, 'announcements'])->name('announcements');
    Route::post('/announcements', [AdminDashboardController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::post('/announcements/{id}/delete', [AdminDashboardController::class, 'deleteAnnouncement'])->name('announcements.delete');
});
