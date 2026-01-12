<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\User\ProfileController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/zeniro', [HomeController::class, 'store'])->name('contact.zeniro');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/detail/{id}', [ProductController::class, 'getDetail'])->name('products.detail');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/delete-selected', [CartController::class, 'deleteSelected'])->name('cart.deleteSelected');

// Checkout (bisa guest atau user)
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Order Success
Route::get('/order/success/{id}', [CartController::class, 'orderSuccess'])->name('order.success');
Route::get('/order/download-receipt/{order_number}', [CartController::class, 'downloadReceipt'])->name('order.receipt.download');
// Track Order (Public - No Auth Required)
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track.order');
Route::post('/track-order/search', [TrackOrderController::class, 'search'])->name('track.order.search');


// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', action: [RegisterController::class, 'register'])->name('register.post');
    Route::post('/login', action: [LoginController::class, 'login'])->name('login.post');
});

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Order History Routes (harus login)
    Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('/orders/detail/{id}', [OrderHistoryController::class, 'getDetail'])->name('orders.detail');
});

// User Profile Routes (Require Auth)
Route::middleware(['auth'])->prefix('account')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Messages
    Route::resource('messages', AdminMessageController::class);
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create'); // Tambah ini
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store'); // Tambah ini
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
});