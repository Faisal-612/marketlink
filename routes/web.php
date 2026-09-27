<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FarmerController as AdminFarmerController;
use App\Http\Controllers\Admin\MarketController as AdminMarketController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\OrderController as FarmerOrderController;
use App\Http\Controllers\Farmer\ProductController as FarmerProductController;
use App\Http\Controllers\Farmer\ProfileController as FarmerProfileController;
use App\Http\Controllers\Farmer\ReviewController as FarmerReviewController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public Guest Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/sitemap', [HomeController::class, 'sitemap'])->name('sitemap');
Route::post('/api/chatbot', [HomeController::class, 'chatbotQuery'])->name('api.chatbot');

// Markets & Map . .  .   .   ..........
Route::get('/markets', [MarketController::class, 'index'])->name('markets.index');
Route::get('/markets/{id}', [MarketController::class, 'show'])->name('markets.show');

// Farmers / Stalls
Route::get('/farmers', [FarmerController::class, 'index'])->name('farmers.index');
Route::get('/farmers/{id}', [FarmerController::class, 'show'])->name('farmers.show');

// Products / Produce Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Shopping Basket & Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Shared Routes (Profile & Favorites)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// Customer Routes (Pre-orders, Reviews)
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Farmer Portal Routes
Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');
    
    // Manage Produce / Stock
    Route::get('/products', [FarmerProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [FarmerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [FarmerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [FarmerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [FarmerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [FarmerProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/toggle-sold-out', [FarmerProductController::class, 'toggleSoldOut'])->name('products.toggle_sold_out');
    Route::post('/products/apply-weekly-template', [FarmerProductController::class, 'applyWeeklyTemplate'])->name('products.apply_weekly_template');

    // Pre-orders Management
    Route::get('/orders', [FarmerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [FarmerOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [FarmerOrderController::class, 'updateStatus'])->name('orders.update_status');

    // Stall Profile & Pickup Schedule
    Route::get('/profile', [FarmerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [FarmerProfileController::class, 'update'])->name('profile.update');

    // Customer Reviews & Replies
    Route::get('/reviews', [FarmerReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/reply', [FarmerReviewController::class, 'reply'])->name('reviews.reply');
});

// Administrator Portal Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Farmers Verification & Moderation
    Route::get('/farmers', [AdminFarmerController::class, 'index'])->name('farmers.index');
    Route::post('/farmers/{id}/approve', [AdminFarmerController::class, 'approve'])->name('farmers.approve');
    Route::post('/farmers/{id}/suspend', [AdminFarmerController::class, 'suspend'])->name('farmers.suspend');
    Route::post('/farmers/{id}/activate', [AdminFarmerController::class, 'activate'])->name('farmers.activate');

    // Customer Account Moderation
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers/{id}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle_status');

    // Markets Management
    Route::get('/markets', [AdminMarketController::class, 'index'])->name('markets.index');
    Route::get('/markets/create', [AdminMarketController::class, 'create'])->name('markets.create');
    Route::post('/markets', [AdminMarketController::class, 'store'])->name('markets.store');
    Route::get('/markets/{id}/edit', [AdminMarketController::class, 'edit'])->name('markets.edit');
    Route::put('/markets/{id}', [AdminMarketController::class, 'update'])->name('markets.update');
    Route::delete('/markets/{id}', [AdminMarketController::class, 'destroy'])->name('markets.destroy');

    // Category Master Data
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Platform Analytics & Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

    // System Announcements
    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{id}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');
});
